<?php

namespace App\Repository;

use App\Entity\RetentionProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RetentionProviderRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, RetentionProvider::class);
    }

    /**
     * @return Array retentions | null
     */
    public function findRetentionsInStatusOpen() {

        return $this->createQueryBuilder('r')
                        ->where('r.statusSri = :status')
                        ->setParameter('status', "open")
                        ->getQuery()
                        ->setMaxResults(1000)
                        ->getResult();
    }

    /**
     *  @param Array $listId
     * @return Array retentions | null
     */
    public function changeStatusInArrayToInProcess($listId = []) {
        // 
        return $this->createQueryBuilder('r')
                        ->update()
                        ->set('r.statusSri', '?1')
                        ->where('r.id IN (:ids)')
                        ->setParameter('ids', $listId)
                        ->setParameter(1, "in_process")
                        ->getQuery()->execute();
    }

    /**
     * buscar las retenciones que esten devuletas por el sri, que 
     * su fecha de creada sea mayor a 7 días y que no se hayan enviado mas de dos veces
     * @return Array retentions | null
     */
    public function findRetentionsInStatusReturnedSri() {
        $today = new \DateTime('now');
        $date = $this->subIntervalDays(new \DateTime('now'), 7);
        return $this->createQueryBuilder('r')
                        ->where('r.statusSri = :status')
                        ->andWhere('r.createAtReal >= :dateInterval')
                        ->andWhere('r.attempts <= :attempts')
                        ->setParameter('attempts', 5)
                        ->setParameter('status', "returned_sri")
                        ->setParameter('dateInterval', $date->format('Y-m-d'))
                        ->getQuery()
                        ->setMaxResults(1000)
                        ->getResult();
    }

    /**
     * @return Array retentions | null
     */
    public function findRetentionsInStatusApprovedSri() {

        return $this->createQueryBuilder('r')
                        ->where('r.statusSri = :status')
                        ->setParameter('status', "approved_sri_xml_local_success")
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @param int $order, field atribute
     * @return Array retentions | null
     */
    public function findRetentionsInStatusApprovedSriAllDocuments() {

        return $this->createQueryBuilder('r')
                        ->where('r.statusSri = :status')
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
