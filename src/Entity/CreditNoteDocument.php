<?php

// api/src/Entity/Book.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * A creditNote.
 * @ORM\Table(name="credit_note_documents")
 * @ORM\Entity
 */
class CreditNoteDocument
{

    /**
     * @var int The id of this creditNote.
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
     * @ORM\OneToOne(targetEntity="CreditNote")
     * @ORM\JoinColumn(name="credit_note_id", referencedColumnName="id")
     */
    protected $creditNote;

    /**
     * @var \DateTimeInterface The privateation date of this creditNote.
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
     * @param App\Entity\CreditNote $creditNote
     *
     * @return App\Entity\CreditNote
     */
    public function setCreditNote($creditNote)
    {
        $this->creditNote = $creditNote;

        return $this;
    }

    /**
     * Get App\Entity\CreditNote $creditNote
     *
     * @return App\Entity\CreditNote
     */
    public function getCreditNote()
    {
        return $this->creditNote;
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
