<?php

namespace App\Command\Invoice;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\InvoiceDocument;
use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\SignXml;
use App\Services\SendEmailNotification;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class CreateXmlLocalInvoice extends Command
{

    private $manager;
    private $signXmlService;
    private $notificationEmails;
    private $params;

    public function __construct(
        EntityManagerInterface $manager,
        SignXml $signXmlService,
        SendEmailNotification $notificationEmails,
        ParameterBagInterface $params
    ) {
        $this->manager = $manager;
        $this->signXmlService = $signXmlService;
        $this->notificationEmails = $notificationEmails;
        $this->params = $params;

        parent::__construct();
    }

    protected function configure()
    {

        // the name of the command (the part after "bin/console")
        $this->setName('app:generate-invoices-with-pdf-xml')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create xmls Local for invoices.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $response = $this->runCommand();
            if ($response["status"]) {
                $output->writeln($response["message"]);
            } else {
                $output->writeln("Hubo un error al intentar crear los xmls de las facturas");
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * @return array  boolean true|false
     */
    private function runCommand()
    {
        try {

            $message = "Documentos xml generados con éxito";
            $status = true;
            $invoices = $this->getInvoicesInStatusOpen();
            if (count($invoices) > 0) {
                $this->saveXmlInInvoice($invoices);
            }
        } catch (\Exception $ex) {
            $status = false;
            $message = "Hubo un error";
        }
        echo "\n";
        return ["message" => $message, "status" => $status];
    }

    /**
     * @return array  invoices 3  days for renovations
     */
    private function saveXmlInInvoice($invoices)
    {

        try {

            foreach ($invoices as $invoice) {
                $document = $this->manager->getRepository('App:InvoiceDocument')
                    ->findOneBy(array("invoice" => $invoice->getId()));
                // create message for invoice in mail
                if (count($document) == 0) {
                    $docXml = $this->generateXmlDocument($invoice);
                    $validate = $this->validateVoucherXml($docXml["fileExportContent"], $docXml["passwordAuthorization"], $invoice);
                    if ($validate) {
                        $document = new InvoiceDocument();
                        //                        $document->setXmlDocumentLocal($docXml["fileExportContent"]);
                        $document->setXmlDocumentLocalName("factura_" . $invoice->getCodeInvoiceExternal() . ".xml");
                        $document->setInvoice($invoice);
                        $invoice->setStatusSri("approved_sri_xml_local_success");
                        $this->manager->persist($document);
                        $this->manager->flush();
                    }
                } else {
                    $docXml = $this->generateXmlDocument($invoice);
                    $validate = $this->validateVoucherXml($docXml["fileExportContent"], $docXml["passwordAuthorization"], $invoice);
                    if ($validate) {
                        $invoice->setStatusSri("approved_sri_xml_local_success");
                        $document->setXmlDocumentLocalName("factura_" . $invoice->getCodeInvoiceExternal() . ".xml");
                        $this->manager->flush();
                    }
                }
            }
            echo "\n";
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
        }

        return $status;
    }

    private function generateXmlDocument(Invoice $invoice)
    {

        try {
            //create  uthorization number for invoice
            $passwordAuthorization = $this->generatePasswordAuthorizationSri($invoice);
            $rootNode = new \SimpleXMLElement("<?xml version='1.0' encoding='UTF-8'?><factura id='comprobante' version='1.0.0'></factura>");
            //Create node two for the document
            $itemOneNode = $rootNode->addChild('infoTributaria');
            $itemOneNode->addChild('ambiente', $invoice->getCompanyRuc()->getAmbientSri());
            $itemOneNode->addChild('tipoEmision', 1);
            $itemOneNode->addChild('razonSocial', $this->signXmlService->clearSpecialCharacters(strtoupper($invoice->getCompanyBusinessName()))); // invertir los nombres
            $itemOneNode->addChild('nombreComercial', $this->signXmlService->clearSpecialCharacters(strtoupper($invoice->getCompanyCommercialName()))); // invertir los nombres
            $itemOneNode->addChild('ruc', trim($invoice->getCompanyRuc()->getCompanyRuc()));
            $itemOneNode->addChild('claveAcceso', trim($passwordAuthorization));
            $itemOneNode->addChild('codDoc', '01'); //codigo de documento 01 para facturas
            $itemOneNode->addChild('estab', trim($invoice->getCompanyCodeSri()));
            $itemOneNode->addChild('ptoEmi', trim($invoice->getCompanyCodeStoreSri()));
            $itemOneNode->addChild('secuencial', trim($invoice->getSequential()));
            $itemOneNode->addChild('dirMatriz', $this->signXmlService->clearSpecialCharacters($invoice->getMatrixAddress()));
            //Create node two for the document
            $itemTwoNode = $rootNode->addChild('infoFactura');
            $itemTwoNode->addChild('fechaEmision', $invoice->getCreateAtReal()->format("d/m/Y"));
            $itemTwoNode->addChild('dirEstablecimiento', $this->signXmlService->clearSpecialCharacters($invoice->getStoreAddress()));
            if ($invoice->getSpecialContributorStatus()) {
                $itemTwoNode->addChild('contribuyenteEspecial', trim($invoice->getSpecialContributor())); //verificar si es o no
            }

            if ($invoice->getObligedAccountingStatus()) { //verificar si es o no
                $obligedAccounting = "SI";
            } else {
                $obligedAccounting = "NO";
            }
            $itemTwoNode->addChild('obligadoContabilidad', $obligedAccounting);
            $itemTwoNode->addChild('tipoIdentificacionComprador', $invoice->getTypeIdentificationClientSri());
            $itemTwoNode->addChild('razonSocialComprador', $this->signXmlService->clearSpecialCharacters($invoice->getClientName()));
            $itemTwoNode->addChild('identificacionComprador', trim($invoice->getIdentificationClient()));
            $itemTwoNode->addChild('totalSinImpuestos', $invoice->getTotalWithoutTax());
            $itemTwoNode->addChild('totalDescuento', $invoice->getTotalDiscount());

            //create node one for tax
            $itemTwoNodeTax = $itemTwoNode->addChild('totalConImpuestos');
            $itemTwoNodeTaxChild = $itemTwoNodeTax->addChild('totalImpuesto');
            $itemTwoNodeTaxChild->addChild('codigo', 2);
            $itemTwoNodeTaxChild->addChild('codigoPorcentaje', trim($invoice->getCodeDiscountSri()));
            $itemTwoNodeTaxChild->addChild('baseImponible', $invoice->getTaxableBase());
            $itemTwoNodeTaxChild->addChild('valor', $invoice->getValueDiscount());
            //close node one for tax

            if ($invoice->getGratificationValue() != "") {
                $itemTwoNode->addChild('propina', trim($invoice->getGratificationValue()));
            }

            $itemTwoNode->addChild('importeTotal', $invoice->getTotalAmount());
            $itemTwoNode->addChild('moneda', 'DOLAR');

            // Open payment 
            $paymentsNode = $itemTwoNode->addChild('pagos');
            $paymentsNodeChild = $paymentsNode->addChild('pago');
            $paymentsNodeChild->addChild('formaPago', trim($invoice->getPaymentMethodSri()));
            $paymentsNodeChild->addChild('total', $invoice->getTotalAmount());
            $paymentsNodeChild->addChild('plazo', 0);
            $paymentsNodeChild->addChild('unidadTiempo', 'dias');
            // close payment 

            //create node details for products in invoice
            $itemThreeNode = $rootNode->addChild('detalles');
            if ($invoice->getProducts()->count()) {
                foreach ($invoice->getProducts() as $product) {
                    $itemThreeNodeChild = $itemThreeNode->addChild('detalle');
                    $descriptionProduct = $this->signXmlService->clearSpecialCharacters($product->getDescription());
                    $descriptionProduct = $this->signXmlService->clearSpecialCharacters($descriptionProduct);
                    $itemThreeNodeChild->addChild('descripcion', $descriptionProduct);
                    $itemThreeNodeChild->addChild('cantidad', trim($product->getQuantity()));
                    $itemThreeNodeChild->addChild('precioUnitario', $product->getPvpUnit());
                    $itemThreeNodeChild->addChild('descuento', $product->getPvpsIndto() - $product->getPvpTotal());
                    $itemThreeNodeChild->addChild('precioTotalSinImpuesto', $product->getPvpTotal());
                    $itemThreeNodeChildTax = $itemThreeNodeChild->addChild('impuestos');
                    $itemThreeNodeChildTaxChild = $itemThreeNodeChildTax->addChild('impuesto');
                    $itemThreeNodeChildTaxChild->addChild('codigo', 2);
                    $itemThreeNodeChildTaxChild->addChild('codigoPorcentaje', $product->getCodeIvaSri());
                    $itemThreeNodeChildTaxChild->addChild('tarifa', trim($product->getIva()));
                    //Valor neto x iva entre 100
                    $itemThreeNodeChildTaxChild->addChild('baseImponible', $product->getPvpTotal());
                    $valorTax = ($product->getPvpTotal() * $product->getIva()) / 100;
                    $itemThreeNodeChildTaxChild->addChild('valor', number_format($valorTax, 2, '.', '')); // sacar el precente
                }
            }

            $fileXmlName = dirname(__DIR__) . "/../files/xml_local/invoice/factura_" . $invoice->getCodeInvoiceExternal() . ".xml";
            $rootNode->asXML($fileXmlName);
            $certPath = dirname(__DIR__) . "/../files/company/key_sri/" . $invoice->getCompanyRuc()->keyFile->contentUrl; // Convertir pfx to pem 

            $this->signXmlService
                ->sign(
                    $fileXmlName,
                    $certPath,
                    $invoice->getCompanyRuc()->keyFile->password,
                    "factura_" . $invoice->getCodeInvoiceExternal() . ".xml",
                    "invoice"
                );
            $fileExportContent = file_get_contents(dirname(__DIR__) . "/../files/xml_local/invoice/xsig_factura_" . $invoice->getCodeInvoiceExternal() . ".xml");
        } catch (\Exception $ex) {

            $invoice->setStatusSri("open");
            $invoice->setMessageErrorLocal("ERROR: " . $ex->getMessage());
            $invoice->setMessageSri("ERROR: Es posible que la clave de su archivo p12 no sea correcta por favor verifiquela, cambie el nombre del archivo .p12 sin espacios y envielo nuevamente");
            $this->manager->flush();
            return false;
        }
        return ["fileExportContent" => $fileExportContent, "passwordAuthorization" => $passwordAuthorization];
    }

    private function validateVoucherXml($docXml, $password, Invoice $invoice)
    {

        /* Open Intanciamos el cliente soap para la recepcion de las facturas */
        if ($invoice->getCompanyRuc()->getAmbientSri() == 1) {
            $wsdl = $this->params->get('URL_SRI_RECEPTION_TEST');
            $wsdlAuthorization = $this->params->get('URL_SRI_AUTHORIZATION_TEST');
        } else {
            $wsdl = $this->params->get('URL_SRI_RECEPTION_PROD');
            $wsdlAuthorization = $this->params->get('URL_SRI_AUTHORIZATION_PROD');
        }
        /* close Intanciamos el cliente soap para la recepcion de las facturas */
        $message = "";
        try {
            $soapClient = new \SoapClient($wsdl, array('trace' => true, 'keep_alive' => false));
            $conection = $soapClient->validarComprobante(["xml" => $docXml]);
            $status = false;
            if ($conection->RespuestaRecepcionComprobante->estado == "RECIBIDA") {

                $soapClientAuthorization = new \SoapClient($wsdlAuthorization);
                $authorization = $soapClientAuthorization->autorizacionComprobante(["claveAccesoComprobante" => trim($password)]);

                $statusMessgeSri = $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->estado;
                if ($statusMessgeSri == "AUTORIZADO") {
                    $voucher = $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                    $docXmlSigneSri = new \SimpleXMLElement($voucher);
                    $fileXmlName = dirname(__DIR__) . "/../files/xml_local/invoice/aprovada_sri_factura_" . $invoice->getCodeInvoiceExternal() . ".xml";
                    $docXmlSigneSri->asXML($fileXmlName);
                    $invoice->setStatusSri("approved_sri");
                    $numberAuthorizationSri = $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->numeroAutorizacion;
                    $invoice->setNumberAuthorizationSri($numberAuthorizationSri);
                    $authorizationDateStart = $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->fechaAutorizacion;
                    $invoice->setAuthorizationDateStart(new \DateTime($authorizationDateStart));
                    $invoice->setMessageSri("FACTURA APROBADA POR EL SRI SIN INCONVENIENTES");
                    $invoice->setAmbientSri($authorizationDateStart = $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->ambiente);
                    $status = true;
                } else {
                    $message = $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes->mensaje->mensaje . " - " . $authorization->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->mensajes->mensaje->informacionAdicional;
                    $invoice->setMessageSri("ERROR! DEVUELTA POR: " . $message);
                    $invoice->setStatusSri("returned_sri");
                }
            } else {
                $idError = "";
                $message = "Imposible capturar el mensaje (el Sri no emitió respuesta)";
                if (isset($conection->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes->mensaje)) {
                    $message = $conection->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes->mensaje->mensaje;
                    $idError = $conection->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes->mensaje->identificador;
                    if (isset($conection->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes->mensaje->informacionAdicional)) {
                        $message .= "--" . $conection->RespuestaRecepcionComprobante->comprobantes->comprobante->mensajes->mensaje->informacionAdicional;
                    }
                }
                if ($idError != 43 && $idError != "") {
                    $invoice->setIdErrorSri($idError);
                    $invoice->setStatusSri("returned_sri");
                    $invoice->setMessageSri("ERROR! DEVUELTA POR: " . $message);
                } else {
                    $invoice->setStatusSri("approved_sri");
                    $invoice->setMessageSri("FACTURA APROBADA POR EL SRI SIN INCONVENIENTES");
                }
                $invoice->setNumberAuthorizationSri($password);
                if ($idError != "") {
                    $invoice->setIdErrorSri($idError);
                }
            }

            $invoice->setAttempts(1);
            $this->manager->flush();
            if ($message != "") {

                $this->notificationEmails->sendEmailNotificationInvoice($invoice);
            }
            echo "...";
        } catch (\Exception $e) {
            $status = false;
            $invoice->setAttempts($invoice->getAttempts() + 1);
            $invoice->setStatusSri("open");
            $invoice->setMessageErrorLocal($invoice->getMessageErrorLocal() . " ----- ERROR -----: " . $e->getMessage());
            $this->manager->flush();
        }
        return $status;
    }

    /**
     * @return array  invoices 3  days for renovations
     */
    private function getInvoicesInStatusOpen()
    {

        $invoices = $this->manager->getRepository('App:Invoice')
            ->findInvoicesInStatusOpen();
        $listId = [];
        foreach ($invoices as $invoice) {
            $listId[] = $invoice->getId();
        }
        $this->manager->getRepository('App:Invoice')
            ->changeStatusInArrayToInProcess($listId);
        return $invoices;
    }

    /**
     * @return array  invoices 3  days for renovations
     */
    private function generatePasswordAuthorizationSri(Invoice $invoice): string
    {
        $sequential = explode("-", $invoice->getCodeInvoiceExternal());
        $password = $invoice->getCreateAtReal()->format("dmY");
        $password .= "01"; //factura
        $password .= $invoice->getCompanyRuc()->getCompanyRuc();
        $password .= $invoice->getCompanyRuc()->getAmbientSri(); //tipo ambiente
        $password .= $sequential[0] . $sequential[1];
        $password .= $invoice->getSequential();
        $password .= substr($invoice->getSequential(), 1); // código númerico
        $password .= 1;
        $mod11 = $this->calculateMod11($password);
        $password .= $mod11; // digitador verificador
        return $password;
    }


    /*
    * Calculate mod 11
    */
    private function calculateMod11($data): int
    {
        $weights = [
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7,
            2, 3, 4, 5, 6, 7
        ];
        // If data is not a string...
        if (!is_string($data)) {
            throw new \InvalidArgumentException('debes pasar un argumento de tipo entero.');
        }
        // Split the string into individual characters
        $characters = strrev($data);
        $checkDigitSum = 0;
        for ($i = 0; $i < count($weights); $i++) {
            // Add the multiplication of these two to the checkDigitSum           
            $checkDigitSum += ((int) $weights[$i] * (int) $characters[$i]);
        }
        // Divide the sum by 11 and get the remainder
        $checkDigitRemainder = $checkDigitSum % 11;
        // Minus the remainder from 11
        $checkDigit = 11 - $checkDigitRemainder;
        // Adjust the final values if necessary
        if ($checkDigit === 11) {
            $checkDigit = 0;
        } elseif ($checkDigit === 10) {
            $checkDigit = 1;
        }
        return $checkDigit;
    }
}
