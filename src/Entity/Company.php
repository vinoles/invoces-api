<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ApiResource(
 * description= "Entidad para Gestionar las compañias afiladas",
 * iri="http://schema.org/Company"
 * )
 * @ApiFilter(SearchFilter::class, properties={"companyRuc": "exact"})
 * @ORM\Entity
 */
class Company
{

    /**
     * ruc registrado de la empresa | funciona como id
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="company_ruc", type="string", length=25, nullable=false, unique=true)
     */
    private $companyRuc;

    /**
     * razonSocial de la empresa (nombre)
     * @var string
     *
     * @ORM\Column(name="company_business_name", type="string", length=255, nullable=false)
     */
    private $companyBusinessName;

    /**
     * nombreComercial ( nombre corto de la empresa)
     * @var string
     *
     * @ORM\Column(name="company_commercial_name", type="string", length=255, nullable=false)
     */
    private $companyCommercialName;

    /**
     * estab código sri autorizado de la empresa
     * @var string
     *
     * @ORM\Column(name="company_code_sri", type="string", length=255, nullable=false)
     */
    private $companyCodeSri;

    /**
     * dirMatriz direccipon principal de la empresa
     * @var string
     *
     * @ORM\Column(name="matrix_address", type="text", length=65535, nullable=true)
     */
    private $matrixAddress;

    /**
     * teléfono en la factura.
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * Logo para la impresion de la factura, opcional para crear o Usar el Post, Puede agregarlo una vez tenga una empresa registrada por medio de un PUT,
     * @var MediaObject|null
     * @ORM\OneToOne(targetEntity="FileLogoCompany")
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/logo")
     */
    public $logo;

    /**
     * Archivo para firmar electronicamente los xml, opcional para crear o Usar el Post, Puede agregarlo una vez tenga una empresa registrada por medio de un PUT,
     * @var MediaObject|null
     * @ORM\OneToOne(targetEntity="FileKeyCompany")
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/keyFile")
     */
    public $keyFile;

    /**
     * ambiente para enviar al Sri.
     * @var string
     *
     * @ORM\Column(name="ambient_sri", type="integer", nullable=true)
     */
    public $ambientSri;

    /**
     * @var listado de facturas asociadas a la empresa
     *
     * @ORM\OneToMany(targetEntity="Invoice", mappedBy="companyRuc")
     */
    private $invoices;

    /**
     * @var listado de sucursales asociadas a la empresa
     *
     * @ORM\OneToMany(targetEntity="CompanyBranchOffice", mappedBy="companyRuc")
     */
    private $branchOffices;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->branchOffices = new ArrayCollection();
    }

    /**
     * Set companyRuc
     *
     * @param string $companyRuc
     *
     * @return Invoice
     */
    public function setCompanyRuc($companyRuc)
    {
        $this->companyRuc = $companyRuc;

        return $this;
    }

    /**
     * Get companyRuc
     *
     * @return string
     */
    public function getCompanyRuc()
    {
        return $this->companyRuc;
    }

    /**
     * Set companyBusinessName
     *
     * @param string $companyBusinessName
     *
     * @return Invoice
     */
    public function setCompanyBusinessName($companyBusinessName)
    {
        $this->companyBusinessName = $companyBusinessName;

        return $this;
    }

    /**
     * Get companyBusinessName
     *
     * @return string
     */
    public function getCompanyBusinessName()
    {
        return $this->companyBusinessName;
    }

    /**
     * Set companyCommercialName
     *
     * @param string $companyCommercialName
     *
     * @return Invoice
     */
    public function setCompanyCommercialName($companyCommercialName)
    {
        $this->companyCommercialName = $companyCommercialName;

        return $this;
    }

    /**
     * Get companyCommercialName
     *
     * @return string
     */
    public function getCompanyCommercialName()
    {
        return $this->companyCommercialName;
    }

    /**
     * Set companyCodeSri
     *
     * @param string $companyCodeSri
     *
     * @return Invoice
     */
    public function setCompanyCodeSri($companyCodeSri)
    {
        $this->companyCodeSri = $companyCodeSri;

        return $this;
    }

    /**
     * Get companyCodeSri
     *
     * @return string
     */
    public function getCompanyCodeSri()
    {
        return $this->companyCodeSri;
    }

    /**
     * Set matrixAddress
     *
     * @param string $matrixAddress
     *
     * @return Invoice
     */
    public function setMatrixAddress($matrixAddress)
    {
        $this->matrixAddress = $matrixAddress;

        return $this;
    }

    /**
     * Get matrixAddress
     *
     * @return string
     */
    public function getMatrixAddress()
    {
        return $this->matrixAddress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Invoice
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $mbientSri
     *
     * @return Invoice
     */
    public function setAmbientSri($ambientSri)
    {
        $this->ambientSri = $ambientSri;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getAmbientSri()
    {
        return $this->ambientSri;
    }

    /**
     * Get invoices
     *
     * @return \ArrayCollection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * Get branchOffices
     *
     * @return \ArrayCollection
     */
    public function getBranchOffices()
    {
        return $this->branchOffices;
    }
}
