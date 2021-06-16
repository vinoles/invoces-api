<?php

namespace App\Command\Invoice;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Invoice;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\SaveEmailSpool;

class CreateEmailsForInvoice extends Command
{

    private $manager;
    private $container;
    private $saveEmail;

    public function __construct(
        EntityManagerInterface $manager,
        ContainerInterface $container,
        SaveEmailSpool $saveEmail
    ) {
        $this->manager = $manager;
        $this->container = $container;
        $this->saveEmail = $saveEmail;
        
        parent::__construct();
    }

    protected function configure()
    {

        // the name of the command (the part after "bin/console")
        $this->setName('app:create-emails-for-invoice')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create xmls Local for conection to SRI.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $response = $this->runCommand();
            if ($response["status"]) {
                $output->writeln($response["message"]);
                //llmar comando para el envio de facturas por medio de emails una vez creados los correos
                $command = $this->getApplication()->find('app:send-emails-open');
                $command->run($input, $output);
            } else {
                $output->writeln("Hubo un error al intentar crear los correos de las facturas");
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
            $status = true;
            $invoices = $this->getInvoicesInStatusApprovedSri();
            if (count($invoices) > 0) {
                $this->generateEmails($invoices);
                $message = "correos para facturas generados con éxito";
            } else {
                $message = "No hay elementos para crear correos";
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
    private function generateEmails($invoices)
    {

        try {

            foreach ($invoices as $invoice) {
                if ($invoice->getClientEmail() != "") {
                    $email = $invoice->getClientEmail();

                    $document = $this->manager->getRepository('App:InvoiceDocument')
                        ->findOneBy(array("invoice" => $invoice->getId()));
                    // create message for invoice in mail
                    $message = $this->getMessageEmail($invoice);
                    $this->saveEmail->saveEmailInvoice($email, $invoice->getClientName(), $message, "Factura " . $invoice->getCodeInvoiceExternal() . " aprobada por SRI", $document);
                } else {
                    $invoice->setStatusSri("approved_sri_true");
                }
                echo "...
                ";
            }
            $this->manager->flush();
            $status = true;
        } catch (\Exception $ex) {
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
            ->findInvoicesInStatusApprovedSriAllDocuments();

        return $invoices;
    }

    /*
     * Message for client subscriptions expired
     */

    private function getMessageEmail(Invoice $invoice)
    {

        $template = $this->container->get('twig')
            ->render(
                'emails/send_invoice_for_client.html.twig',
                array(
                    'invoice' => $invoice
                )
            );
        return $template;
    }
}
