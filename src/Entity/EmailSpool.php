<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Entity(repositoryClass="App\Repository\EmailSpoolRepository")
 * @ORM\Table(name="email_spool")
 */
class EmailSpool
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Por favor, ingrese el correo")
     * @ORM\Column(name="to_email", type="string", length=255, nullable=false)
     */
    private $toEmail;

    /**
     * @var string
     * @Assert\NotBlank(message="Por favor, ingrese el nombre")
     * @ORM\Column(name="to_name", type="string", length=255, nullable=true)
     */
    private $toName;

    /**
     * @var string
     * @Assert\NotBlank(message="Por favor, escriba un mensaje")
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;

    /**
     * @var string
     * @Assert\NotBlank(message="Por favor, ingrese el asunto")
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="attempts", type="integer", nullable=false)
     */
    private $attempts;

    /**
     * @var \DateTime $lastAttemptAt
     *
     * @ORM\Column(name="last_attempt_at", type="datetime", nullable=true)
     */
    private $lastAttemptAt;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="InvoiceDocument")
     * @ORM\JoinColumn(name="invoice_document_id", referencedColumnName="id")
     */
    protected $invoiceDocument;

    /**
     * @ORM\OneToOne(targetEntity="RetentionDocument")
     * @ORM\JoinColumn(name="retention_document_id", referencedColumnName="id")
     */
    protected $retentionDocument;


    /**
     * @ORM\OneToOne(targetEntity="CreditNoteDocument")
     * @ORM\JoinColumn(name="credit_note_document_id", referencedColumnName="id")
     */
    protected $creditNoteDocument;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set toEmail
     *
     * @param string $toEmail
     *
     * @return EmailSpool
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * Get toEmail
     *
     * @return string
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * Set toName
     *
     * @param string $toName
     *
     * @return EmailSpool
     */
    public function setToName($toName)
    {
        $this->toName = $toName;

        return $this;
    }

    /**
     * Get toName
     *
     * @return string
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailSpool
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param $message
     *
     * @return EmailSpool
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /*
     * Get message
     *
     * return $message
     */

    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return EmailSpool
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set attempts
     *
     * @param integer $attempts
     *
     * @return EmailSpool
     */
    public function setAttempts($attempts)
    {
        $this->attempts = $attempts;

        return $this;
    }

    /**
     * Get attempts
     *
     * @return integer
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * Set lastAttemptAt
     *
     * @param \DateTime $lastAttemptAt
     *
     * @return EmailSpool
     */
    public function setLastAttemptAt($lastAttemptAt)
    {
        $this->lastAttemptAt = $lastAttemptAt;

        return $this;
    }

    /**
     * Get lastAttemptAt
     *
     * @return \DateTime
     */
    public function getLastAttemptAt()
    {
        return $this->lastAttemptAt;
    }

    /**
     * Set createdAt
     *
     * @param App\Entity\InvoiceDocument $invoiceDocument
     *
     * @return App\Entity\InvoiceDocument
     */
    public function setInvoiceDocument($invoiceDocument)
    {
        $this->invoiceDocument = $invoiceDocument;

        return $this;
    }

    /**
     * Get App\Entity\InvoiceDocument $invoiceDocument
     *
     * @return App\Entity\Document
     */
    public function getInvoiceDocument()
    {
        return $this->invoiceDocument;
    }


    /**
     * Set retentionDocument
     *
     * @param App\Entity\RetentionDocument $retentionDocument
     *
     * @return App\Entity\RetentionDocument
     */
    public function setRetentionDocument($retentionDocument)
    {
        $this->retentionDocument = $retentionDocument;

        return $this;
    }


    /**
     * Get App\Entity\RetentionDocument $retentionDocument
     *
     * @return App\Entity\RetentionDocument
     */
    public function getRetentionDocument()
    {
        return $this->retentionDocument;
    }

    /**
     * Set creditNoteDocument
     *
     * @param App\Entity\CreditNoteDocument $creditNoteDocument
     *
     * @return App\Entity\CreditNoteDocument
     */
    public function setCreditNoteDocument($creditNoteDocument)
    {
        $this->creditNoteDocument = $creditNoteDocument;

        return $this;
    }


    /**
     * Get App\Entity\CreditNoteDocument $creditNoteDocument
     *
     * @return App\Entity\CreditNoteDocument
     */
    public function getCreditNoteDocument()
    {
        return $this->creditNoteDocument;
    }


    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return EmailSpool
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
