<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class InvoiceRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * @return Array invoices | null
     */
    public function findInvoicesInStatusOpen() {

        return $this->createQueryBuilder('i')
                        ->where('i.statusSri = :status')
                        ->setParameter('status', "open")
                        ->getQuery()
//                        ->setMaxResults(1000)
                        ->getResult();
    }

    /**
     * @param Array $listId
     * @return Array invoices | null
     */
    public function changeStatusInArrayToInProcess($listId = []) {
        // 
        return $this->createQueryBuilder('i')
                ->update()
                ->set('i.statusSri', '?1')
                ->where('i.id IN (:ids)')
                ->setParameter('ids', $listId)
                ->setParameter(1, "in_process")
                ->getQuery()->execute();
    }

    /**
     * buscar las facturas que esten devuletas por el sri y que 
     * su fecha de creada sea mayor a 7 días
     * @return Array invoices | null
     */
    public function findInvoicesInStatusReturnedSri() {
        $today = new \DateTime('now');
        $date = $this->subIntervalDays(new \DateTime('now'), 20);
        return $this->createQueryBuilder('i')
                        ->where('i.statusSri = :status')
                        ->andWhere('i.createAtReal >= :dateInterval')
                        ->andWhere('i.attempts <= :attempts')
                        ->setParameter('attempts', 5)
                        ->setParameter('status', "returned_sri")
                        ->setParameter('dateInterval', $date->format('Y-m-d'))
                        ->getQuery()
                        ->setMaxResults(1000)
                        ->getResult();
    }

    /**
     * @return Array invoices | null
     */
    public function findInvoicesInStatusApprovedSri() {

        return $this->createQueryBuilder('i')
                        ->where('i.statusSri = :status')
                        ->setParameter('status', "approved_sri_xml_local_success")
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @return Array invoices | null
     */
    public function findInvoicesInStatusApprovedSriAllDocuments() {

        return $this->createQueryBuilder('i')
                        ->where('i.statusSri = :status')
                        ->setParameter('status', "approved_sri_all_documents")
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @param date $date
     * @param int $days interval
     */
    private function subIntervalDays($date, $days) {

        $interval = new \DateInterval('P' . $days . 'D');
        $date->sub($interval);
        return $date;
    }

}
