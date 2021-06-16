<?php

namespace App\Services;

use App\Entity\EmailSpool;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;

class SendStacksOfEmails
{

    private $manager;
    private $mailer;
    private $validator;


    public function __construct(EntityManagerInterface $manager, \Swift_Mailer $mailer, ValidatorInterface $validator)
    {

        $this->manager = $manager;
        $this->mailer = $mailer;
        $this->validator = $validator;
    }

    public function sendEmailStacks($emails)
    {

        // Validate email
        $emailConstraint = new Assert\Email();
        $countError = 0;
        $confDirXmlLocal = dirname(__DIR__) . '/files/xml_local/';
        $confDirPdfInvoice = dirname(__DIR__) . '/files/invoice_pdf/';
        $confDirPdfRetention = dirname(__DIR__) . '/files/retention_pdf/';
        $confDirPdfCreditNote = dirname(__DIR__) . '/files/credit_note_pdf/';
        $type = "";
        /** @var EmailSpool $email */
        foreach ($emails as $email) {

            $addresses = array_map(function ($a) {
                return trim($a);
            }, explode(';', $email->getToEmail()));

            $invalidAddresses = [];
            $addresses = array_filter($addresses, function ($a) use ($emailConstraint, &$invalidAddresses) {
                $errors = $this->validator->validate(
                    $a,
                    $emailConstraint
                );

                $isValidAddress = count($errors) === 0 && filter_var($a, FILTER_VALIDATE_EMAIL) !== false;

                if (!$isValidAddress) {
                    $invalidAddresses[] = $a;
                }

                return $isValidAddress;
            });

            if (!empty($addresses)) {
                $send = false;
                try {
                    if ($email->getInvoiceDocument()) {
                        $type = "invoice";
                        $attachmentXmlSignedSri = \Swift_Attachment::fromPath($confDirXmlLocal . $type . "/" . "aprovada_sri_" . $email->getInvoiceDocument()->getXmlDocumentLocalName());
                        $attachmentPdf = \Swift_Attachment::fromPath($confDirPdfInvoice . $email->getInvoiceDocument()->getPdfDocumentName());
                    } else if ($email->getRetentionDocument()) {
                        $type = "retention";
                        $attachmentXmlSignedSri = \Swift_Attachment::fromPath($confDirXmlLocal . $type . "/" . "aprovada_sri_" . $email->getRetentionDocument()->getXmlDocumentLocalName());
                        $attachmentPdf = \Swift_Attachment::fromPath($confDirPdfRetention . $email->getRetentionDocument()->getPdfDocumentName());
                    } else if ($email->getCreditNoteDocument()) {
                        $type = "credit_note";
                        $attachmentXmlSignedSri = \Swift_Attachment::fromPath($confDirXmlLocal . $type . "/" . "aprovada_sri_" . $email->getCreditNoteDocument()->getXmlDocumentLocalName());
                        $attachmentPdf = \Swift_Attachment::fromPath($confDirPdfCreditNote . $email->getCreditNoteDocument()->getPdfDocumentName());
                    }

                    $message = (new \Swift_Message())
                        ->setSubject($email->getSubject())
                        ->setFrom("no_replay@facturandoecuador.com")
                        ->setTo($addresses)
                        ->attach($attachmentXmlSignedSri)
                        ->attach($attachmentPdf)
                        ->setBody($email->getMessage(), 'text/html');
                    $send = $this->mailer->send($message);
                } catch (\Exception $e) {
                    $e->getMessage();
                }

                $attempts = $email->getAttempts() + 1;

                if ($send) {
                    $email->setStatus(1);
                } else {
                    $countError = $countError + 1;
                    if ($attempts < 3) {
                        $email->setStatus(0);
                    } else {
                        $email->setStatus(-1);
                    }
                }
            } else {
                $countError = $countError + 1;
                $attempts = $email->getAttempts() + 1;

                $email->setStatus(-1);
            }
            $email->setAttempts($attempts);
            $email->setLastAttemptAt(new \DateTime('now'));

            if ($type == "invoice") {
                $idInvoice = $email->getInvoiceDocument()->getInvoice()->getId();
                $invoice = $this->manager->getRepository('App:Invoice')->find($idInvoice);
                $invoice->setStatusSri("approved_sri_true");
            } else if ($type == "retention") {
                $idRetention = $email->getRetentionDocument()->getRetention()->getId();
                $retention = $this->manager->getRepository('App:RetentionProvider')->find($idRetention);
                $retention->setStatusSri("approved_sri_true");
            } else if ($type == "credit_note") {
                $idCreditNote = $email->getCreditNoteDocument()->getCreditNote()->getId();
                $creditNote = $this->manager->getRepository('App:CreditNote')->find($idCreditNote);
                $creditNote->setStatusSri("approved_sri_true");
            }
            $this->manager->flush();
        }

        $response = ["count_error" => $countError];

        return $response;
    }
}
