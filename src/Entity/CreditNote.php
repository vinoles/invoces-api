<?php
//Credit notes

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
 * A creditNote.
 * @ORM\Table(name="credit_note")
 * @ApiResource(
 * description= "Entidad para la gestion de las notas de crédito",
 * itemOperations={
 *     "get"
 * })
 * @ORM\Entity(repositoryClass="App\Repository\CreditNoteRepository")
 * @ApiFilter(SearchFilter::class, properties={"companyRuc": "exact","codeCreditNoteExternal": "exact"})
 */
class CreditNote
{


    /**
     * @var int id de la nota de crédito.
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
     * Nombre del cliiente en la nota de crédito
     * @var string
     *
     * @ORM\Column(type="string", name="client_name", length=100, nullable=false)
     */
    private $clientName;

    /**
     * Nombre del cliiente en la nota de crédito
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
     * @ORM\Column(name="total_payment_for_client", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $totalPaymentInForClient;

    //close infoFactura XML information

    /**
     * @var string
     * |código de la nota de crédito de la aplicaion externa
     *
     * @ORM\Column(type="string", name="code_credit_notes_external", length=20, nullable=false, unique=true)
     */
    private $codeCreditNoteExternal;


    /**
     * @var string
     * |código de la factura a que se le hace la notas de crédito
     *
     * @ORM\Column(type="string", name="number_docomumento_modified", length=20, nullable=false)
     */
    private $numberDocomumentoModified;

    /**
     * @var string
     * |fecha  de la factura a que se le hace la notas de crédito
     *
     * @ORM\Column(type="date", name="broadcast_date_docomumento_modified")
     */
    private $broadcastDateDocomumentoModified;

    /**
     * @var Review[] Available products for this creditNote.
     *
     * @ORM\OneToMany(targetEntity="CreditNoteProducts", mappedBy="creditNote")
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * Set statusSri
     *
     * @param string $statusSri
     *
     * @return CreditNote
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
     * @return CreditNote
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
     * @return CreditNote
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
     * Set codeCreditNoteExternal
     *
     * @param string $codeCreditNoteExternal
     *
     * @return CreditNote
     */
    public function setCodeCreditNoteExternal($codeCreditNoteExternal)
    {
        $this->codeCreditNoteExternal = $codeCreditNoteExternal;

        return $this;
    }

    /**
     * Get codeCreditNoteExternal
     *
     * @return string
     */
    public function getCodeCreditNoteExternal()
    {
        return $this->codeCreditNoteExternal;
    }

    /**
     * Set codeCreditNoteExternal
     *
     * @param string $numberDocomumentoModified
     *
     * @return CreditNote
     */
    public function setNumberDocomumentoModified($numberDocomumentoModified)
    {
        $this->numberDocomumentoModified = $numberDocomumentoModified;

        return $this;
    }

    /**
     * Get numberDocomumentoModified
     *
     * @return string
     */
    public function getNumberDocomumentoModified()
    {
        return $this->numberDocomumentoModified;
    }

    /**
     * Set broadcastDateDocomumentoModified
     *
     * @param string $broadcastDateDocomumentoModified
     *
     * @return CreditNote
     */
    public function setBroadcastDateDocomumentoModified($broadcastDateDocomumentoModified)
    {
        $this->broadcastDateDocomumentoModified = $broadcastDateDocomumentoModified;

        return $this;
    }

    /**
     * Get numberDocomumentoModified
     *
     * @return string
     */
    public function getBroadcastDateDocomumentoModified()
    {
        return $this->broadcastDateDocomumentoModified;
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
