<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Mapping\Annotation as Gedmo;

//atributes basics for entities 
use App\Entity\Traits\TraitCompanyDataBasic;

/**
 * A etention.
 * @ORM\Table(name="retention_provider")
 * @ApiResource(
 * description= "Entidad para la gestion de las facturas",
 * itemOperations={
 *     "get"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\RetentionProviderRepository")
 * @ApiFilter(SearchFilter::class, properties={"companyRuc": "exact","codeRetentionExternal": "exact"})
 */
class RetentionProvider
{

    /**
     * @var int id de la factura.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    use TraitCompanyDataBasic;

    /**
     * ttipo de identificaión reconocida por el sri
     * @var string
     *
     * @ORM\Column(type="string", name="type_identification_provider_sri", length=20, nullable=false)
     */
    private $typeIdentificationProviderSri;

    /**
     * Nombre del cliiente en la factura
     * @var string
     *
     * @ORM\Column(type="string", name="provider_name", length=100, nullable=false)
     */
    private $providerName;

    /**
     * Nombre del cliiente en la factura
     * @var string
     *
     * @ORM\Column(type="string", name="provider_email", length=100, nullable=true)
     */
    private $providerEmail;

    /**
     * valor de la identificacion del proveedor
     * @var string
     *
     * @ORM\Column(type="string", name="identification_provider", length=20, nullable=false)
     */
    private $identificationProvider;


    /**
     * @var float
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalAmount;

    /**
     * @var \DateTimeInterface fecha de inicio de autorización sri
     * @ORM\Column(type="date", name="fiscal_period", nullable=true)
     */
    private $fiscalPeriod;

    //close infoFactura XML information

    /**
     * @var string
     * |código de la retencion de la aplicaion externa
     *
     * @ORM\Column(type="string", name="code_retention_external", length=20, nullable=false, unique=true)
     */
    private $codeRetentionExternal;

    /**
     * @var string
     * |código de la factura de la aplicaion externa
     *
     * @ORM\Column(type="string", name="support_document_number", length=20, nullable=false)
     */
    private $supportDocumentNumber;

    /**
     * @var string
     * |código de la factura de la aplicaion externa
     *
     * @ORM\Column(type="date", name="support_document_create")
     */
    private $supportDocumentCreate;
    /**
     * @var taxes[] Available taxes for this invoice.
     *
     * @ORM\OneToMany(targetEntity="RetentionTaxes", mappedBy="retention")
     */
    private $taxes;

    public function __construct()
    {
        $this->taxes = new ArrayCollection();
    }

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
     * Set typeIdentificationProviderSri
     *
     * @param string $typeIdentificationProviderSri
     *
     * @return Retention
     */
    public function setTypeIdentificationProviderSri($typeIdentificationProviderSri)
    {
        $this->typeIdentificationProviderSri = $typeIdentificationProviderSri;

        return $this;
    }

    /**
     * Get typeIdentificationProviderSri
     *
     * @return string
     */
    public function getTypeIdentificationProviderSri()
    {
        return $this->typeIdentificationProviderSri;
    }

    /**
     * Set providerName
     *
     * @param string $providerName
     *
     * @return Retention
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;

        return $this;
    }

    /**
     * Get providerName
     *
     * @return string
     */
    public function getProviderEmail()
    {
        return $this->providerEmail;
    }

    /**
     * Set providerEmail
     *
     * @param string $providerEmail
     *
     * @return Retention
     */
    public function setProviderEmail($providerEmail)
    {
        $this->providerEmail = $providerEmail;

        return $this;
    }

    /**
     * Get providerName
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * Set identificationProvider
     *
     * @param string $identificationProvider
     *
     * @return Retention
     */
    public function setIdentificationProvider($identificationProvider)
    {
        $this->identificationProvider = $identificationProvider;

        return $this;
    }

    /**
     * Get identificationProvider
     *
     * @return string
     */
    public function getIdentificationProvider()
    {
        return $this->identificationProvider;
    }

    /**
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return Retention
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set fiscalPeriod
     *
     * @param  date $totalAmount
     *
     * @return Retention
     */
    public function setFiscalPeriod($fiscalPeriod)
    {
        $this->fiscalPeriod = $fiscalPeriod;

        return $this;
    }

    /**
     * Get fiscalPeriod
     *
     * @return date
     */
    public function getFiscalPeriod()
    {
        return $this->fiscalPeriod;
    }

    /**
     * Set codeRetentionExternal
     *
     * @param string $codeRetentionExternal
     *
     * @return Retention
     */
    public function setCodeRetentionExternal($codeRetentionExternal)
    {
        $this->codeRetentionExternal = $codeRetentionExternal;

        return $this;
    }

    /**
     * Get codeRetentionExternal
     *
     * @return string
     */
    public function getCodeRetentionExternal()
    {
        return $this->codeRetentionExternal;
    }

    /**
     * Set supportDocumentNumber
     *
     * @param string $supportDocumentNumber
     *
     * @return Retention
     */
    public function setSupportDocumentNumber($supportDocumentNumber)
    {
        $this->supportDocumentNumber = $supportDocumentNumber;

        return $this;
    }

    /**
     * Get supportDocumentNumber
     *
     * @return string
     */
    public function getSupportDocumentNumber()
    {
        return $this->supportDocumentNumber;
    }

    /**
     * Get taxes
     *
     * @return \ArrayCollection
     */
    public function getTaxes()
    {
        return $this->taxes;
    }
    /**
     * Set createAtReal
     *
     * @param \DateTime $createAtReal
     *
     * @return Invoice
     */
    public function setSupportDocumentCreate($supportDocumentCreate)
    {
        $this->supportDocumentCreate = $supportDocumentCreate;

        return $this;
    }

    /**
     * Get createAtReal
     *
     * @return \DateTime
     */
    public function getSupportDocumentCreate()
    {
        return $this->supportDocumentCreate;
    }
}
