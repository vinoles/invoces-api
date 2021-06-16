<?php

//Invoice

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
 * A invoice.
 * @ORM\Table(name="invoice")
 * @ApiResource(
 * description= "Entidad para la gestion de las facturas",
 * itemOperations={
 * "get"={"method"="GET"},
 * "put"={"method"="PUT"}
 * })
 * @ORM\Entity(repositoryClass="App\Repository\InvoiceRepository")
 * @ApiFilter(SearchFilter::class, properties={"companyRuc": "exact","codeInvoiceExternal": "exact"})
 */
class Invoice
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
     * @ORM\Column(type="string", name="type_identification_client_sri", length=20, nullable=false)
     */
    private $typeIdentificationClientSri;

    /**
     * Nombre del cliiente en la factura
     * @var string
     *
     * @ORM\Column(type="string", name="client_name", length=100, nullable=false)
     */
    private $clientName;

    /**
     * Nombre del cliiente en la factura
     * @var string
     *
     * @ORM\Column(type="string", name="client_email", length=100, nullable=true)
     */
    private $clientEmail;

    /**
     * valor de la identificacion del cliente
     * @var string
     *
     * @ORM\Column(type="string", name="identification_client", length=20, nullable=false)
     */
    private $identificationClient;

    /**
     * valor total sin impuestos
     * @var float
     *
     * @ORM\Column(name="total_without_tax", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $totalWithoutTax;

    /**
     * valor del descuento total
     * @var float
     *
     * @ORM\Column(name="total_discount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalDiscount;

    /**
     * codigo de descuentos sri |Descuentos 
     * @var integer
     *
     * @ORM\Column(name="code_discount_sri", type="integer", nullable=false)
     */
    private $codeDiscountSri;

    /**
     * codigoPorcentaje |Descuentos 
     * @var integer
     *
     * @ORM\Column(name="code_percentage_sri", type="integer", nullable=false)
     */
    private $codePercentageSri;

    /**
     * base imponible  del descuento|Descuentos 
     * @var float
     *
     * @ORM\Column(name="taxable_base", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $taxableBase;

    /**
     *  valor  del descuento |Descuentos 
     * @var float
     *
     * @ORM\Column(name="value_discount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $valueDiscount;

    /**
     *  propina
     * @var float
     *
     * @ORM\Column(name="gratification_value",  type="float", nullable=true)
     */
    private $gratificationValue;

    /**
     * @var float
     *
     * @ORM\Column(name="total_amount", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalAmount;

    /**
     * código para la frma de pago del sri |Pagos
     * @var string
     *
     * @ORM\Column(type="string", name="payment_method_sri", length=20, nullable=false)
     */
    private $paymentMethodSri;

    /**
     * Total pagado por el cliente |Pagos
     * @var string
     *
     * @ORM\Column(name="total_payment_for_client", type="float", nullable=false)
     */
    private $totalPaymentInForClient;

    //close infoFactura XML information

    /**
     * @var string
     * |código de la factura de la aplicaion externa
     *
     * @ORM\Column(type="string", name="code_invoice_external", length=20, nullable=false, unique=true)
     */
    private $codeInvoiceExternal;

    /**
     * @var Review[] Available products for this invoice.
     *
     * @ORM\OneToMany(targetEntity="InvoiceProducts", mappedBy="invoice")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * Set typeIdentificationClientSri
     *
     * @param string $typeIdentificationClientSri
     *
     * @return Invoice
     */
    public function setTypeIdentificationClientSri($typeIdentificationClientSri)
    {
        $this->typeIdentificationClientSri = $typeIdentificationClientSri;

        return $this;
    }

    /**
     * Get typeIdentificationClientSri
     *
     * @return string
     */
    public function getTypeIdentificationClientSri()
    {
        return $this->typeIdentificationClientSri;
    }

    /**
     * Set clientName
     *
     * @param string $clientName
     *
     * @return Invoice
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName
     *
     * @return string
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * Set clientEmail
     *
     * @param string $clientEmail
     *
     * @return Invoice
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;

        return $this;
    }

    /**
     * Get clientName
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set identificationClient
     *
     * @param string $identificationClient
     *
     * @return Invoice
     */
    public function setIdentificationClient($identificationClient)
    {
        $this->identificationClient = $identificationClient;

        return $this;
    }

    /**
     * Get identificationClient
     *
     * @return string
     */
    public function getIdentificationClient()
    {
        return $this->identificationClient;
    }

    /**
     * Set totalWithoutTax
     *
     * @param float $totalWithoutTax
     *
     * @return Invoice
     */
    public function setTotalWithoutTax($totalWithoutTax)
    {
        $this->totalWithoutTax = $totalWithoutTax;

        return $this;
    }

    /**
     * Get totalWithoutTax
     *
     * @return float
     */
    public function getTotalWithoutTax()
    {
        return $this->totalWithoutTax;
    }

    /**
     * Set totalDiscount
     *
     * @param float $totalDiscount
     *
     * @return Invoice
     */
    public function setTotalDiscount($totalDiscount)
    {
        $this->totalDiscount = $totalDiscount;

        return $this;
    }

    /**
     * Get totalDiscount
     *
     * @return float
     */
    public function getTotalDiscount()
    {
        return $this->totalDiscount;
    }

    /**
     * Set codeDiscountSri
     *
     * @param integer $codeDiscountSri
     *
     * @return Invoice
     */
    public function setCodeDiscountSri($codeDiscountSri)
    {
        $this->codeDiscountSri = $codeDiscountSri;

        return $this;
    }

    /**
     * Get codeDiscountSri
     *
     * @return integer
     */
    public function getCodeDiscountSri()
    {
        return $this->codeDiscountSri;
    }

    /**
     * Set codePercentageSri
     *
     * @param integer $codePercentageSri
     *
     * @return Invoice
     */
    public function setCodePercentageSri($codePercentageSri)
    {
        $this->codePercentageSri = $codePercentageSri;

        return $this;
    }

    /**
     * Get codePercentageSri
     *
     * @return integer
     */
    public function getCodePercentageSri()
    {
        return $this->codePercentageSri;
    }

    /**
     * Set taxableBase
     *
     * @param float $taxableBase
     *
     * @return Invoice
     */
    public function setTaxableBase($taxableBase)
    {
        $this->taxableBase = $taxableBase;

        return $this;
    }

    /**
     * Get taxableBase
     *
     * @return float
     */
    public function getTaxableBase()
    {
        return $this->taxableBase;
    }

    /**
     * Set valueDiscount
     *
     * @param float $valueDiscount
     *
     * @return Invoice
     */
    public function setValueDiscount($valueDiscount)
    {
        $this->valueDiscount = $valueDiscount;

        return $this;
    }

    /**
     * Get valueDiscount
     *
     * @return float
     */
    public function getValueDiscount()
    {
        return $this->valueDiscount;
    }

    /**
     * Set gratificationValue
     *
     * @param float $gratificationValue
     *
     * @return Invoice
     */
    public function setGratificationValue($gratificationValue)
    {
        $this->gratificationValue = $gratificationValue;

        return $this;
    }

    /**
     * Get gratificationValue
     *
     * @return float
     */
    public function getGratificationValue()
    {
        return $this->gratificationValue;
    }

    /**
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return Invoice
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
     * Set paymentMethodSri
     *
     * @param string $paymentMethodSri
     *
     * @return Invoice
     */
    public function setPaymentMethodSri($paymentMethodSri)
    {
        $this->paymentMethodSri = $paymentMethodSri;

        return $this;
    }

    /**
     * Get paymentMethodSri
     *
     * @return string
     */
    public function getPaymentMethodSri()
    {
        return $this->paymentMethodSri;
    }

    /**
     * Set totalPaymentInForClient
     *
     * @param float $totalPaymentInForClient
     *
     * @return Invoice
     */
    public function setTotalPaymentInForClient($totalPaymentInForClient)
    {
        $this->totalPaymentInForClient = $totalPaymentInForClient;

        return $this;
    }

    /**
     * Get totalPaymentInForClient
     *
     * @return float
     */
    public function getTotalPaymentInForClient()
    {
        return $this->totalPaymentInForClient;
    }

    /**
     * Set codeInvoiceExternal
     *
     * @param float $codeInvoiceExternal
     *
     * @return Invoice
     */
    public function setCodeInvoiceExternal($codeInvoiceExternal)
    {
        $this->codeInvoiceExternal = $codeInvoiceExternal;

        return $this;
    }

    /**
     * Get codeInvoiceExternal
     *
     * @return float
     */
    public function getCodeInvoiceExternal()
    {
        return $this->codeInvoiceExternal;
    }
    /**
     * Get products
     *
     * @return \ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
