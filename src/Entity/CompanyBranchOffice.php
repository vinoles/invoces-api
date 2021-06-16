<?php

//CompanyBranchOffice

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
 * CompanyBranchOffice
 *
 * @ORM\Table(name="company_branch_office")
 * @ApiResource(
 * description= "Entidad para Gestionar las sucursales afiladas",
 * iri="http://schema.org/CompanyBranchOffice"
 * )
 * @ApiFilter(SearchFilter::class, properties={"name": "exact"})
 * @ORM\Entity
 */
class CompanyBranchOffice
{

    /**
     * @var int id de la factura.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * nombreComercial ( nombre de la sucursal)
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var companyRuc compañia asociada a la sucursul "/api/companies/123456".
     *
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="branchOffices")
     * @ORM\JoinColumn(name="company_ruc", referencedColumnName="company_ruc")
     */
    private $companyRuc;

    /**
     * companyCodeStoreSri código sri del almacen que hace la factura
     * @var string
     *
     * @ORM\Column(name="company_code_store_sri", type="string", length=255, nullable=false)
     */
    private $companyCodeStoreSri;

    /**
     * Logo para la impresion de la factura, opcional para crear o Usar el Post, Puede agregarlo una vez tenga una esucursal registrada por medio de un PUT,
     * @var MediaObject|null
     * @ORM\OneToOne(targetEntity="FileLogoBranchOffice")
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/logo")
     */
    public $logo;

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
     * Set name
     *
     * @param string $name
     *
     * @return Invoice
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * Set companyCodeStoreSri
     *
     * @param string $companyCodeStoreSri
     *
     * @return Invoice
     */
    public function setCompanyCodeStoreSri($companyCodeStoreSri)
    {
        $this->companyCodeStoreSri = $companyCodeStoreSri;

        return $this;
    }

    /**
     * Get companyCodeStoreSri
     *
     * @return string
     */
    public function getCompanyCodeStoreSri()
    {
        return $this->companyCodeStoreSri;
    }
}
