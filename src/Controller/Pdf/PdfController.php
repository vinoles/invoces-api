<?php

namespace App\Controller\Pdf;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

/**
 * @Route("pdf")
 */
class PdfController extends AbstractController
{

    /**
     *
     * @Route("/invoice/{code}", name="pdf_invoice_code")
     * @Method("GET")
     */
    public function invoiceAction($code)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = ["codeInvoiceExternal" => $code];
        $invoice = $em->getRepository('App:Invoice')->findOneBy($criteria);
        $store = [];
        if ($invoice) {
            $criteriaCompany = ["companyRuc" => $invoice->getCompanyRuc(), "companyCodeStoreSri" => $invoice->getCompanyCodeStoreSri()];
            $store = $em->getRepository('App:CompanyBranchOffice')->findOneBy($criteriaCompany);
        }
        $html = $this->render('pdf/invoice_pdf.html.twig', ["invoice" => $invoice, "code" => $code, "store" => $store]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'factura_' . $code . '.pdf'
        );
    }

    /**
     *
     * @Route("/credit/note/{code}", name="pdf_credit_note_code")
     * @Method("GET")
     */
    public function creditNoteAction($code)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = ["codeCreditNoteExternal" => $code];
        $creditNote = $em->getRepository('App:CreditNote')->findOneBy($criteria);
        $store = [];
        if ($creditNote) {
            $criteriaCompany = ["companyRuc" => $creditNote->getCompanyRuc(), "companyCodeStoreSri" => $creditNote->getCompanyCodeStoreSri()];
            $store = $em->getRepository('App:CompanyBranchOffice')->findOneBy($criteriaCompany);
        }
        $html = $this->render('pdf/credit_note_pdf.html.twig', ["creditNote" => $creditNote, "code" => $code, "store" => $store]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'nota_de_credito_' . $code . '.pdf'
        );
    }

    /**
     *
     * @Route("/retention/{code}", name="pdf_retention_code")
     * @Method("GET")
     */
    public function retentionAction($code)
    {
        $em = $this->getDoctrine()->getManager();
        $criteria = ["codeRetentionExternal" => $code];
        $retention = $em->getRepository('App:RetentionProvider')->findOneBy($criteria);
        $store = [];
        if ($retention) {
            $criteriaCompany = ["companyRuc" => $retention->getCompanyRuc(), "companyCodeStoreSri" => $retention->getCompanyCodeStoreSri()];
            $store = $em->getRepository('App:CompanyBranchOffice')->findOneBy($criteriaCompany);
        }
        $html = $this->render('pdf/retention_pdf.html.twig', ["retention" => $retention, "code" => $code, "store" => $store]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'retention_' . $code . '.pdf'
        );
    }
}
