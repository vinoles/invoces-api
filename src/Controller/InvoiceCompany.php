<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Invoice;


class InvoiceCompany
{
        /**
     * @Route(
     *     name="invoive_for_company",
     *     path="/invoices/{id}/company",
     *     methods={"GET"},
     *     defaults={
     *         "_api_resource_class"=Invoice::class,
     *         "_api_item_operation_name"="invoive_for_company"
     *     }
     * )
     */
    
    public function getInvoicesForCompany($id)
    {
        
        return $id;
    }
}