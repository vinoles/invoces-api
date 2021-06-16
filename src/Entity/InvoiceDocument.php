<?php

// api/src/Entity/Book.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * A invoice.
 * @ORM\Table(name="invoice_documents")
 * @ORM\Entity
 */
class InvoiceDocument
{

    /**
     * @var int The id of this invoice.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="xml_document_local_name", nullable=true)
     */
    private $xmlDocumentLocalName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="pdf_document_name", nullable=true)
     */
    private $pdfDocumentName;

    /**
     * @ORM\OneToOne(targetEntity="Invoice")
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    protected $invoice;

    /**
     * @var \DateTimeInterface The privateation date of this invoice.
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set xmlDocumentLocalName
     *
     * @param $xmlDocumentLocalName
     *
     * @return EmailSpool
     */
    public function setXmlDocumentLocalName($xmlDocumentLocalName)
    {
        $this->xmlDocumentLocalName = $xmlDocumentLocalName;

        return $this;
    }

    /*
     * Get xmlDocumentLocalName
     *
     * return $xmlDocumentLocalName
     */

    public function getXmlDocumentLocalName()
    {
        return $this->xmlDocumentLocalName;
    }

    /**
     * Set pdfDocumentName
     * @param $pdfDocumentName
     *
     * @return EmailSpool
     */
    public function setPdfDocumentName($pdfDocumentName)
    {
        $this->pdfDocumentName = $pdfDocumentName;

        return $this;
    }

    /*
     * Get pdfDocumentName
     *
     * return $pdfDocumentName
     */

    public function getPdfDocumentName()
    {
        return $this->pdfDocumentName;
    }

    /**
     * Set createdAt
     *
     * @param App\Entity\Invoice $invoice
     *
     * @return App\Entity\Invoice
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get App\Entity\Invoice $invoice
     *
     * @return App\Entity\Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
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
