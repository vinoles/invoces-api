<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\EmailSpool;
use App\Entity\InvoiceDocument;
use App\Entity\RetentionDocument;
use App\Entity\CreditNoteDocument;

class SaveEmailSpool
{

    private $container;
    private $manager;

    public function __construct(EntityManagerInterface $manager, ContainerInterface $container)
    {
        $this->container = $container;
        $this->manager = $manager;
    }

    public function saveEmailInvoice($toEmail, $toName = null, $message, $subject, InvoiceDocument $invoiceDocument)
    {
        try {
           
            $email = $this->manager->getRepository('App:EmailSpool')
                ->findOneBy(array("invoiceDocument" => $invoiceDocument->getId()));

            if (count($email) == 0) {
                $email = new EmailSpool();
                if (!is_null($toName)) {
                    $email->setToName($toName);
                }
                $email->setInvoiceDocument($invoiceDocument);
                $email->setToEmail($toEmail);
                $email->setStatus(0);
                $email->setMessage($message);
                $email->setSubject($subject);
                $email->setAttempts(0);
                $this->manager->persist($email);
            } else {
                $email->setToEmail($toEmail);
                $email->setStatus(0);
                $email->setMessage($message);
                $email->setSubject($subject);
                $email->setAttempts(0);
            }
            $this->manager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function saveEmailRetention($toEmail, $toName = null, $message, $subject, RetentionDocument $retentionDocument)
    {

        try {
            $em = $this->container->get('doctrine')->getManager("default");
            $email = $this->manager->getRepository('App:EmailSpool')
                ->findOneBy(array("retentionDocument" => $retentionDocument->getId()));
            if (count($email) == 0) {
                $email = new EmailSpool();
                if (!is_null($toName)) {
                    $email->setToName($toName);
                }
                $email->setRetentionDocument($retentionDocument);
                $email->setToEmail($toEmail);
                $email->setStatus(0);
                $email->setMessage($message);
                $email->setSubject($subject);
                $email->setAttempts(0);
                $this->manager->persist($email);
            } else {
                $email->setToEmail($toEmail);
                $email->setStatus(0);
                $email->setMessage($message);
                $email->setSubject($subject);
                $email->setAttempts(0);
            }
            $this->manager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function saveEmailCreditNote($toEmail, $toName = null, $message, $subject, CreditNoteDocument $creditNoteDocument)
    {

        try {

            $email = $this->manager->getRepository('App:EmailSpool')
                ->findOneBy(array("creditNoteDocument" => $creditNoteDocument->getId()));
            if (count($email) == 0) {
                $email = new EmailSpool();
                if (!is_null($toName)) {
                    $email->setToName($toName);
                }
                $email->setCreditNoteDocument($creditNoteDocument);
                $email->setToEmail($toEmail);
                $email->setStatus(0);
                $email->setMessage($message);
                $email->setSubject($subject);
                $email->setAttempts(0);
                $this->manager->persist($email);
            } else {
                $email->setToEmail($toEmail);
                $email->setStatus(0);
                $email->setMessage($message);
                $email->setSubject($subject);
                $email->setAttempts(0);
            }
            $this->manager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
