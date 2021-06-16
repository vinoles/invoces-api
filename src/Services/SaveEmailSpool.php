<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EmailSpool;
use App\Entity\InvoiceDocument;
use App\Entity\RetentionDocument;
use App\Entity\CreditNoteDocument;

class SaveEmailSpool
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function saveEmailInvoice($toEmail, $toName = null, $message, $subject, InvoiceDocument $invoiceDocument)
    {
        try {

            $email = $this->manager->getRepository('App:EmailSpool')
                ->findOneBy(array("invoiceDocument" => $invoiceDocument->getId()));

            if (!$email) {
                $email = new EmailSpool();
                if (!is_null($toName)) {
                    $email->setToName($toName);
                }
                $email->setInvoiceDocument($invoiceDocument);
                
            } 
            $this->saveElement($email, $toEmail, $toName, $message, $subject);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function saveEmailRetention($toEmail, $toName = null, $message, $subject, RetentionDocument $retentionDocument)
    {

        try {

            $email = $this->manager->getRepository('App:EmailSpool')
                ->findOneBy(array("retentionDocument" => $retentionDocument->getId()));
            if (!$email) {
                $email = new EmailSpool();
                if (!is_null($toName)) {
                    $email->setToName($toName);
                }
                $email->setRetentionDocument($retentionDocument);
            }
            $this->saveElement($email, $toEmail, $toName, $message, $subject);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function saveEmailCreditNote($toEmail, $toName = null, $message, $subject, CreditNoteDocument $creditNoteDocument)
    {

        try {

            $email = $this->manager->getRepository('App:EmailSpool')
                ->findOneBy(array("creditNoteDocument" => $creditNoteDocument->getId()));
            if (!$email) {
                $email = new EmailSpool();
                if (!is_null($toName)) {
                    $email->setToName($toName);
                }
                $email->setCreditNoteDocument($creditNoteDocument);
            }
            $this->saveElement($email, $toEmail, $toName, $message, $subject);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function saveElement(EmailSpool $email, $toEmail, $toName = null, $message, $subject)
    {
        $email->setToEmail($toEmail);
        $email->setStatus(0);
        $email->setMessage($message);
        $email->setSubject($subject);
        $email->setAttempts(0);
        $this->manager->persist($email);
        $this->manager->flush();
    }
}
