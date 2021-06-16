<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;


class DeleteFileInFolderCommand extends Command
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        
        parent::__construct();
    }


    /** @var \Symfony\Component\Console\Output\OutputInterface $output */
    private $output;
    public $confDirXmlLocal = '/files/xml_local/';
    public $confDirPdfInvoice = '/files/invoice_pdf/';
    public $confDirPdfRetention = '/files/retention_pdf/';
    public $confDirPdfCreditNote = '/files/credit_note_pdf/';

    protected function configure()
    {

        // the name of the command (the part after "bin/console")
        $this->setName('app:delete-emails-in-status-sent')
            // the short description shown while running "php bin/console list"
            ->setDescription('Delete stacks emails .');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $start = microtime(true);
        $this->output = $output;
        try {
            $response = $this->searchInvoicesSentEemails();
            $this->output->writeln("Elementos borrados con éxito" . ' // ' . (microtime(true) - $start) . ' segundos.');
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
        }
        return $status;
    }

    /**
     * Search emails expired and remove
     * @return bollean  status
     */
    private function searchInvoicesSentEemails()
    {
        try {

            $emailsForInvoices = $this->manager->getRepository('App:EmailSpool')->searchInvoicesSentEemails();
            if (count($emailsForInvoices) > 0) {
                foreach ($emailsForInvoices as $email) {
                    $delete = $this->deleteFileForInvoices($email);
                    if ($delete) {
                        $this->manager->remove($email);
                    }
                }
            }
            $emailsForRetentions = $this->manager->getRepository('App:EmailSpool')->searchRetentionsSentEemails();
            if (count($emailsForRetentions) > 0) {
                foreach ($emailsForRetentions as $email) {
                    $delete = $this->deleteFileForRetentions($email);
                    if ($delete) {
                        $this->manager->remove($email);
                    }
                }
            }
            $emailsForCreditNotes = $this->manager->getRepository('App:EmailSpool')->searchCreditNotesSentEemails();
            if (count($emailsForCreditNotes) > 0) {
                foreach ($emailsForCreditNotes as $email) {
                    $delete = $this->deleteFileForCreditNotes($email);
                    if ($delete) {
                        $this->manager->remove($email);
                    }
                }
            }
            $status = true;
            $this->manager->flush();
            echo "...";
        } catch (\Exception $ex) {
            $status = false;
            echo $ex->getMessage();
        }
        echo "\n";
        return $status;
    }

    /**
     * Search emails expired and remove
     * @return bollean  status
     */
    private function deleteFileForInvoices($email)
    {
        try {

            unlink(dirname(__DIR__) . $this->confDirXmlLocal . "invoice/" . $email->getInvoiceDocument()->getXmlDocumentLocalName());
            unlink(dirname(__DIR__) . $this->confDirXmlLocal . "invoice/" . "xsig_" . $email->getInvoiceDocument()->getXmlDocumentLocalName());
            unlink(dirname(__DIR__) . $this->confDirPdfInvoice . $email->getInvoiceDocument()->getPdfDocumentName());
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
            echo $ex->getMessage();
        }
        return $status;
    }

    /**
     * Search emails expired and remove
     * @return bollean  status
     */
    private function deleteFileForRetentions($email)
    {
        try {

            unlink(dirname(__DIR__) . $this->confDirXmlLocal . "retention/" . $email->getRetentionDocument()->getXmlDocumentLocalName());
            unlink(dirname(__DIR__) . $this->confDirXmlLocal . "retention/" . "xsig_" . $email->getRetentionDocument()->getXmlDocumentLocalName());
            unlink(dirname(__DIR__) . $this->confDirPdfRetention . $email->getRetentionDocument()->getPdfDocumentName());
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
            echo $ex->getMessage();
        }
        return $status;
    }

    /**
     * Search emails expired and remove
     * @return bollean  status
     */
    private function deleteFileForCreditNotes($email)
    {
        try {

            unlink(dirname(__DIR__) . $this->confDirXmlLocal . "credit_note/" . $email->getCreditNoteDocument()->getXmlDocumentLocalName());
            unlink(dirname(__DIR__) . $this->confDirXmlLocal . "credit_note/" . "xsig_" . $email->getCreditNoteDocument()->getXmlDocumentLocalName());
            unlink(dirname(__DIR__) . $this->confDirPdfCreditNote . $email->getCreditNoteDocument()->getPdfDocumentName());
            $status = true;
        } catch (\Exception $ex) {
            $status = false;
            echo $ex->getMessage();
        }
        return $status;
    }
}
