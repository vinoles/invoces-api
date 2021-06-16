<?php

namespace App\Command\Invoice;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Invoice;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreatePdfInvoice extends Command
{

    private $manager;
    private $container;


    public function __construct(
        EntityManagerInterface $manager,
        ContainerInterface $container
    ) {
        $this->manager = $manager;
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {

        // the name of the command (the part after "bin/console")
        $this->setName('app:create-pdf-invoice')

            // the short description shown while running "php bin/console list"
            ->setDescription('Send Inovices.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $response = $this->runCommand();
            if ($response["status"]) {
                $output->writeln($response["message"]);
                //llamar comando que crea los emails una vez genrado los pdf
                $command = $this->getApplication()->find('app:create-emails-for-invoice');
                $command->run($input, $output);
            } else {
                $output->writeln("Hubo un error al intentar crear los pdfs de las facturas");
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

            $message = "Documentos pdfs generados con éxito ";
            $status = true;
            $invoices = $this->getInvoicesInStatusApprovedSri();
            if (count($invoices) > 0) {
                $this->savePdfInInvoice($invoices);
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
    private function savePdfInInvoice($invoices)
    {

        try {

            foreach ($invoices as $invoice) {
                $document = $this->manager->getRepository('App:InvoiceDocument')
                    ->findOneBy(array("invoice" => $invoice->getId()));

                // create message for invoice in mail

                $this->generateTemplatePdf($invoice);
                $invoice->setStatusSri("approved_sri_all_documents");
                $document->setPdfDocumentName("factura_" . $invoice->getCodeInvoiceExternal() . ".pdf");
            }
            $this->manager->flush();
            $status = true;
        } catch (\Exception $ex) {
            $ex->getMessage();
            $status = false;
        }
        echo "\n";
        return $status;
    }

    private function generateTemplatePdf(Invoice $invoice)
    {
        try {
            $template = $this->container->get('twig')
                ->render('pdf/invoice_pdf.html.twig', ['invoice' => $invoice]);

            $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $template,
                dirname(__DIR__) . "/../files/invoice_pdf/factura_" . $invoice->getCodeInvoiceExternal() . ".pdf"
            );
            echo "...";
            $status = true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = false;
        }
        return $status;
    }

    /**
     * @return array  invoices 3  days for renovations
     */
    private function getInvoicesInStatusApprovedSri()
    {

        $invoices = $this->manager->getRepository('App:Invoice')
            ->findInvoicesInStatusApprovedSri();

        return $invoices;
    }
}
