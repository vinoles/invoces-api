<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * CreditNoteProducts
 *
 * @ORM\Table(name="credit_notes_products")
 * @ApiResource(
 * description= "Entidad para gestionar los productos asociados a una factura",
 * itemOperations={
 *     "get"
 * })
 * @ApiFilter(SearchFilter::class, properties={"creditNote": "exact"})
 * @ORM\Entity
 */
class CreditNoteProducts
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
     * cantidad para el  producto
     * @var float
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * descripción del producto
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var float
     * valor del iva
     * @ORM\Column(name="iva", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $iva;


    /**
     * precio sin decuento
     * @var float
     *
     * @ORM\Column(name="pvps_indto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $pvpsIndto;

    /**
     * precio total sin impuesto
     * @var float
     *
     * @ORM\Column(name="pvp_total", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $pvpTotal;

    /**
     * precio unitario del producto
     * @var float
     *
     * @ORM\Column(name="pvp_unit", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $pvpUnit;

    /**
     * precio unitario del producto
     * @var float
     *
     * @ORM\Column(name="reference",  type="string", length=255, nullable=false)
     */
    private $reference;

    /**
     * @var CreditNoteProducts factura asociada a la linea subir tipo "/api/credit_notes/1".
     *
     * @ORM\ManyToOne(targetEntity="CreditNote", inversedBy="products")
     * @ORM\JoinColumn(name="credit_note_id", referencedColumnName="id")
     */
    private $creditNote;


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
     * Set quantity
     *
     * @param float $quantity
     *
     * @return CreditNote
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return CreditNote
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set iva
     *
     * @param float $iva
     *
     * @return CreditNote
     */
    public function setIva($iva)
    {
        $this->iva = $iva;

        return $this;
    }

    /**
     * Get iva
     *
     * @return float
     */
    public function getIva()
    {
        return $this->iva;
    }

    /**
     * Set pvpsIndto
     *
     * @param float $pvpsIndto
     *
     * @return CreditNote
     */
    public function setPvpsIndto($pvpsIndto)
    {
        $this->pvpsIndto = $pvpsIndto;

        return $this;
    }

    /**
     * Get pvpsIndto
     *
     * @return float
     */
    public function getPvpsIndto()
    {
        return $this->pvpsIndto;
    }

    /**
     * Set pvpTotal
     *
     * @param float $pvpTotal
     *
     * @return CreditNote
     */
    public function setPvpTotal($pvpTotal)
    {
        $this->pvpTotal = $pvpTotal;

        return $this;
    }

    /**
     * Get pvpTotal
     *
     * @return float
     */
    public function getPvpTotal()
    {
        return $this->pvpTotal;
    }

    /**
     * Set pvpUnit
     *
     * @param float $pvpUnit
     *
     * @return CreditNote
     */
    public function setPvpUnit($pvpUnit)
    {
        $this->pvpUnit = $pvpUnit;

        return $this;
    }

    /**
     * Get pvpUnit
     *
     * @return float
     */
    public function getPvpUnit()
    {
        return $this->pvpUnit;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return CreditNote
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }


    /**
     * Set creditNote
     *
     * @param \App\Entity\CreditNote $creditNote
     *
     * @return CreditNote
     */
    public function setCreditNote($creditNote = null)
    {
        $this->creditNote = $creditNote;

        return $this;
    }

    /**
     * Get creditNote
     *
     * @return \App\Entity\CreditNote
     */
    public function getCreditNote()
    {
        return $this->creditNote;
    }
}
