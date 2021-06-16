<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * RetentionTaxes
 *
 * @ORM\Table(name="retention_taxes")
 * @ApiResource(
 * description= "Entidad para gestionar los impuestos de  asociados a una retención",
 * itemOperations={
 *     "get"
 * })
 * @ApiFilter(SearchFilter::class, properties={"retention": "exact"})
 * @ORM\Entity
 */
class RetentionTaxes
{

    /**
     * @var int The id of this retention.
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
     * @ORM\Column(name="code_type_sri",  type="string", length=255, nullable=false)
     */
    private $codeTypeSri;

    /**
     * descripción del producto
     * @var string
     *
     * @ORM\Column(name="code_retention_sri",   type="string", length=255, nullable=true)
     */
    private $codeRetention;

    /**
     * @var float
     * valor del iva
     * @ORM\Column(name="base", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $base;

    /**
     * precio sin decuento
     * @var float
     *
     * @ORM\Column(name="pvps_indto", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $percentage;

    /**
     * precio total sin impuesto
     * @var float
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $total;

    /**
     * @var Retencion asociada a la linea subir tipo "/api/retentions/1".
     *@ORM\ManyToOne(targetEntity="RetentionProvider", inversedBy="taxes")
     *@ORM\JoinColumn(name="retention_id", referencedColumnName="id")
     */
    private $retention;

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
     * Set codeTypeSri
     *
     * @param string $codeTypeSri
     *
     * @return RetentionTaxes
     */
    public function setCodeTypeSri($codeTypeSri)
    {
        $this->codeTypeSri = $codeTypeSri;

        return $this;
    }

    /**
     * Get codeRetention
     *
     * @return string
     */
    public function getCodeRetention()
    {
        return $this->codeRetention;
    }

    /**
     * Set codeRetention
     *
     * @param string $codeRetention
     *
     * @return RetentionTaxes
     */
    public function setCodeRetention($codeRetention)
    {
        $this->codeRetention = $codeRetention;

        return $this;
    }

    /**
     * Get codeTypeSri
     *
     * @return string
     */
    public function getCodeTypeSri()
    {
        return $this->codeTypeSri;
    }

    /**
     * Set base
     *
     * @param string $base
     *
     * @return RetentionTaxes
     */
    public function setBase($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set percentage
     *
     * @param string $percentage
     *
     * @return RetentionTaxes
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return string
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set total
     *
     * @param string $total
     *
     * @return RetentionTaxes
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set retention
     *
     * @param \App\Entity\RetentionInvoiceInPurchases $retention
     *
     * @return Retention
     */
    public function setRetention($retention = null)
    {
        $this->retention = $retention;

        return $this;
    }

    /**
     * Get retention
     *
     * @return \App\Entity\RetentionInvoiceInPurchases
     */
    public function getRetention()
    {
        return $this->retention;
    }
}
