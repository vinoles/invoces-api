<?php

namespace App\Repository;

use App\Entity\CreditNote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CreditNoteRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, CreditNote::class);
    }

    /**
     * @return Array creditNotes | null
     */
    public function findCreditNotesInStatusOpen() {

        return $this->createQueryBuilder('cn')
                        ->where('cn.statusSri = :status')
                        ->setParameter('status', "open")
                        ->getQuery()
                        ->setMaxResults(1000)
                        ->getResult();
    }

    /**
     * @param Array $listId
     * @return Array creditNotes | null
     */
    public function changeStatusInArrayToInProcess($listId = []) {
        // 
        return $this->createQueryBuilder('c')
                        ->update()
                        ->set('c.statusSri', '?1')
                        ->where('c.id IN (:ids)')
                        ->setParameter('ids', $listId)
                        ->setParameter(1, "in_process")
                        ->getQuery()->execute();
    }

    /**
     * buscar lasnotas de crédito que esten devuletas por el sri y que 
     * su fecha de creada sea mayor a 7 días
     * @return Array creditNotes | null
     */
    public function findCreditNotesInStatusReturnedSri() {
        $today = new \DateTime('now');
        $date = $this->subIntervalDays(new \DateTime('now'), 7);
        return $this->createQueryBuilder('cn')
                        ->where('cn.statusSri = :status')
                        ->andWhere('cn.createAtReal >= :dateInterval')
                        ->andWhere('cn.attempts <= :attempts')
                        ->setParameter('attempts', 5)
                        ->setParameter('status', "returned_sri")
                        ->setParameter('dateInterval', $date->format('Y-m-d'))
                        ->getQuery()
                        ->setMaxResults(1000)
                        ->getResult();
    }

    /**
     * @param int $order, field atribute
     * @return Array creditNotes | null
     */
    public function findCreditNotesInStatusApprovedSri() {

        return $this->createQueryBuilder('cn')
                        ->where('cn.statusSri = :status')
                        ->setParameter('status', "approved_sri_xml_local_success")
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @return Array creditNotes | null
     */
    public function findCreditNotesInStatusApprovedSriAllDocuments() {

        return $this->createQueryBuilder('cn')
                        ->where('cn.statusSri = :status')
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
