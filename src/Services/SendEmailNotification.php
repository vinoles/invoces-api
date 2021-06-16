<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Invoice;

class SendEmailNotification {

    private $mailer;
    private $container;

    public function __construct(\Swift_Mailer $mailer, ContainerInterface $container = null) {
        
        $this->mailer = $mailer;
        $this->container = $container;

    }

    public function sendEmailNotificationInvoice(Invoice $invoice) {
        try {
            // Validate email
            $addresses = $invoice->getClientEmail();
            $send = false;

            if (!empty($addresses)) {
                try {
                    
                    $body = $this->container->get('twig')
                        ->render(
                            'emails/send_notification_error_invoice.html.twig', array(
                        'invoice' => $invoice
                            )
                    );
                    $messageEmail = ( new \Swift_Message('Notificación'))
                            ->setSubject("Error en factura " . $invoice->getCodeInvoiceExternal())
                            ->setFrom("no_replay@facturandoecuador.com")
                            ->setTo("jose.ochoa@interactuaclub.com")
                            ->setBody($body, 'text/html');
                    $send = $this->mailer->send($messageEmail) > 0;
                } catch (\Exception $e) {
                    
                }
            }

            if (!$send) {
                if (!isset($sendStacksOfEmails)) {
                    $sendStacksOfEmails = $this->container->get("send.stacks.of.emails");
                }
                
            }
        } catch (\Exception $e) {
           echo $e->getMessage();
            $send = false;
        }

        return $send;
    }

}
