<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * InvoiceProducts
 *
 * @ORM\Table(name="invoice_products")
 * @ApiResource(
 * description= "Entidad para gestionar los productos asociados a una factura",
 * itemOperations={
 * "get"={"method"="GET"},
 * "put"={"method"="PUT"}
 * })
 * @ApiFilter(SearchFilter::class, properties={"invoice": "exact"})
 * @ORM\Entity
 */
class InvoiceProducts
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
     * @var float
     * valor del iva
     * @ORM\Column(name="code_iva_sri", type="string", nullable=false)
     */
    private $codeIvaSri;


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
     * @var InvoiceProducts factura asociada a la linea subir tipo "/invoices/1/company".
     *
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="products")
     *  @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    private $invoice;


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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * Set iva
     *
     * @param float $iva
     *
     * @return Invoice
     */
    public function setCodeIvaSri($codeIvaSri)
    {
        $this->codeIvaSri = $codeIvaSri;

        return $this;
    }

    /**
     * Get iva
     *
     * @return float
     */
    public function getCodeIvaSri()
    {
        return $this->codeIvaSri;
    }
    /**
     * Set pvpsIndto
     *
     * @param float $pvpsIndto
     *
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * Set invoice
     *
     * @param \App\Entity\Invoice $invoice
     *
     * @return Invoice
     */
    public function setInvoice($invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \App\Entity\Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}
