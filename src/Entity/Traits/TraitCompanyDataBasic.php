<?php

namespace App\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait TraitCompanyDataBasic
{
    //open infoTributaria XML information

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
     * @var companyRuc compañia asociada a la factura subir tipo "/api/companies/123456".
     *
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="invoices")
     * @ORM\JoinColumn(name="company_ruc", referencedColumnName="company_ruc")
     */
    private $companyRuc;

    /**
     * código sri autorizado de la empresa
     * @var string
     *
     * @ORM\Column(name="company_code_sri", type="string", length=255, nullable=false)
     */
    private $companyCodeSri;

    /**
     * companyCodeStoreSri código sri del almacen que hace la factura
     * @var string
     *
     * @ORM\Column(name="company_code_store_sri", type="string", length=255, nullable=false)
     */
    private $companyCodeStoreSri;

    /**
     * secuencial de la factura, se toma del codigo que se genera en la factura
     * @var string
     *
     * @ORM\Column(name="sequential", type="string", length=255, nullable=false)
     */
    private $sequential;

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

    //close infoTributaria XML information
    //open infoFactura XML information

    /**
     * fecha real que se crea la factura en la aplicación del cliente
     * @var \DateTimeInterface The publication date of this invoice.
     *
     * @ORM\Column(type="date", name="create_at_real")
     */
    private $createAtReal;

    /**
     * direccion del almacen que emite la factura
     * @var string
     *
     * @ORM\Column(name="store_address", type="text", length=65535, nullable=true)
     */
    private $storeAddress;

    /**
     * valor si es constibuyente especial
     * @var string
     *
     * @ORM\Column(name="special_contributor", type="string", length=255, nullable=true)
     */
    private $specialContributor;

    /**
     * stado si es contribuyente especial o no (true/false)
     * @var string
     *
     * @ORM\Column(name="special_contributor_status",type="boolean", nullable=false)
     */
    private $specialContributorStatus;

    /**
     * valor si es obligado a llevar contabilidad (true/false)
     * @var string
     *
     * @ORM\Column(name="obliged_accounting_status",type="boolean", nullable=false)
     */
    private $obligedAccountingStatus;

    //close infoFactura XML information

    /**
     * open(enviar este estado para crear)|in_process(procesando un documento)|approved_sri|
     * returned_sri|approved_sri_xml_local_success|
     * approved_sri_all_documents|approved_sri_true
     * @var string
     *
     * @ORM\Column(type="string", name="status_sri", length=50, nullable=false)
     */
    private $statusSri;

    /**
     * PRUEBAS|PRODUCCIÓN
     * @var string
     *
     * @ORM\Column(type="string", name="ambient_sri", length=50, nullable=true)
     */
    private $ambientSri;

    /**
     * Se establece un mensaje para crear una factura( ejemplo abierto), a partir de las conexiones
     *  se establece un mensaje retornado por el sri en caso de éxito o de ser rechazado
     * @var string
     *
     * @ORM\Column(type="text", length=65535, name="message_sri", nullable=true)
     */
    private $messageSri;

    /**
     * Controlar los posibles errores locales
     * @var string
     *
     * @ORM\Column(type="text", length=65535, name="message_error_local", nullable=true)
     */
    private $messageErrorLocal;

    /**
     * @var \DateTimeInterface The publication date of this invoice.
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at_api_plataform")
     */
    private $createdAtApiPlataform;

    /**
     * @var \DateTimeInterface fecha de fin de autorización sri
     * @ORM\Column(type="datetime", name="authorization_date_start", nullable=true)
     */
    private $authorizationDateStart;

    /**
     * @var \DateTimeInterface fecha de inicio de autorización sri
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="update_at", nullable=true)
     */
    private $updateAt;

    /**
     * @var string|enviada|aprobada|rechazada
     *
     * @ORM\Column(type="string", name="number_authorization_sri", length=50, nullable=true)
     */
    private $numberAuthorizationSri;

    /**
     * @var integer iniciado en 0
     *
     * @ORM\Column(name="attempts", type="integer", nullable=true)
     */
    private $attempts = 0;

    /**
     * @var integer iniciado en 0
     *
     * @ORM\Column(name="id_error_sri", type="integer", nullable=true)
     */
    private $idErrorSri;

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
     * @return Company
     */
    public function getCompanyRuc()
    {
        return $this->companyRuc;
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

    /**
     * Set sequential
     *
     * @param string $sequential
     *
     * @return Invoice
     */
    public function setSequential($sequential)
    {
        $this->sequential = $sequential;

        return $this;
    }

    /**
     * Get sequential
     *
     * @return string
     */
    public function getSequential()
    {
        return $this->sequential;
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
     * Set createAtReal
     *
     * @param \DateTime $createAtReal
     *
     * @return Invoice
     */
    public function setCreateAtReal($createAtReal)
    {
        $this->createAtReal = $createAtReal;

        return $this;
    }

    /**
     * Get createAtReal
     *
     * @return \DateTime
     */
    public function getCreateAtReal()
    {
        return $this->createAtReal;
    }

    /**
     * Set storeAddress
     *
     * @param string $storeAddress
     *
     * @return Invoice
     */
    public function setStoreAddress($storeAddress)
    {
        $this->storeAddress = $storeAddress;

        return $this;
    }

    /**
     * Get storeAddress
     *
     * @return string
     */
    public function getStoreAddress()
    {
        return $this->storeAddress;
    }

    /**
     * Set specialContributor
     *
     * @param string $specialContributor
     *
     * @return Invoice
     */
    public function setSpecialContributor($specialContributor)
    {
        $this->specialContributor = $specialContributor;

        return $this;
    }

    /**
     * Get specialContributor
     *
     * @return string
     */
    public function getSpecialContributor()
    {
        return $this->specialContributor;
    }

    /**
     * Set specialContributorStatus
     *
     * @param boolean $specialContributorStatus
     *
     * @return Invoice
     */
    public function setSpecialContributorStatus($specialContributorStatus)
    {
        $this->specialContributorStatus = $specialContributorStatus;

        return $this;
    }

    /**
     * Get specialContributorStatus
     *
     * @return boolean
     */
    public function getSpecialContributorStatus()
    {
        return $this->specialContributorStatus;
    }

    /**
     * Set obligedAccountingStatus
     *
     * @param boolean $obligedAccountingStatus
     *
     * @return Invoice
     */
    public function setObligedAccountingStatus($obligedAccountingStatus)
    {
        $this->obligedAccountingStatus = $obligedAccountingStatus;

        return $this;
    }

    /**
     * Get obligedAccountingStatus
     *
     * @return boolean
     */
    public function getObligedAccountingStatus()
    {
        return $this->obligedAccountingStatus;
    }

    /**
     * Set statusSri
     *
     * @param string $statusSri
     *
     * @return Invoice
     */
    public function setStatusSri($statusSri)
    {
        $this->statusSri = $statusSri;

        return $this;
    }

    /**
     * Get statusSri
     *
     * @return string
     */
    public function getStatusSri()
    {
        return $this->statusSri;
    }

    /**
     * Set ambientSri
     *
     * @param string $ambientSri
     *
     * @return Invoice
     */
    public function setAmbientSri($ambientSri)
    {
        $this->ambientSri = $ambientSri;

        return $this;
    }

    /**
     * Get ambientSri
     *
     * @return string
     */
    public function getAmbientSri()
    {
        return $this->ambientSri;
    }

    /**
     * Set messageSri
     *
     * @param string $messageSri
     *
     * @return Invoice
     */
    public function setMessageSri($messageSri)
    {
        $this->messageSri = $messageSri;

        return $this;
    }

    /**
     * Get messageSri
     *
     * @return string
     */
    public function getMessageSri()
    {
        return $this->messageSri;
    }

    /**
     * Set messageErrorLocal
     *
     * @param string $messageErrorLocal
     *
     * @return Invoice
     */
    public function setMessageErrorLocal($messageErrorLocal)
    {
        $this->messageErrorLocal = $messageErrorLocal;

        return $this;
    }

    /**
     * Get messageErrorLocal
     *
     * @return string
     */
    public function getMessageErrorLocal()
    {
        return $this->messageErrorLocal;
    }

    /**
     * Set createdAtApiPlataform
     *
     * @param \DateTime $createdAtApiPlataform
     *
     * @return Invoice
     */
    public function setCreatedAtApiPlataform($createdAtApiPlataform)
    {
        $this->createdAtApiPlataform = $createdAtApiPlataform;

        return $this;
    }

    /**
     * Get createdAtApiPlataform
     *
     * @return \DateTime
     */
    public function getCreatedAtApiPlataform()
    {
        return $this->createdAtApiPlataform;
    }

    /**
     * Set authorizationDateStart
     *
     * @param \DateTime $authorizationDateStart
     *
     * @return Invoice
     */
    public function setAuthorizationDateStart($authorizationDateStart)
    {
        $this->authorizationDateStart = $authorizationDateStart;

        return $this;
    }

    /**
     * Get authorizationDateStart
     *
     * @return \DateTime
     */
    public function getAuthorizationDateStart()
    {
        return $this->authorizationDateStart;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Invoice
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set numberAuthorizationSri
     *
     * @param String $numberAuthorizationSri
     *
     * @return Invoice
     */
    public function setNumberAuthorizationSri($numberAuthorizationSri)
    {
        $this->numberAuthorizationSri = $numberAuthorizationSri;

        return $this;
    }

    /**
     * Get numberAuthorizationSri
     *
     * @return String
     */
    public function getNumberAuthorizationSri()
    {
        return $this->numberAuthorizationSri;
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
     * Set attempts
     *
     * @param integer $idErrorSri
     *
     */
    public function setIdErrorSri($idErrorSri)
    {
        $this->idErrorSri = $idErrorSri;

        return $this;
    }

    /**
     * Get attempts
     *
     * @return integer
     */
    public function getIdErrorSri()
    {
        return $this->idErrorSri;
    }
}
