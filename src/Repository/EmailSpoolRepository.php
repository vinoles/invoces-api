<?php

namespace App\Repository;

use App\Entity\EmailSpool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmailSpoolRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailSpool::class);
    }


    /**
     * @return Array suscriptions | null
     */
    public function checkEmailSpoolsMinus90Days($date) {
        $qb = $this->createQueryBuilder('e');

        return $qb->where('e.createdAt <= :date')
                        ->andWhere($qb->expr()->orX($qb->expr()->eq('e.status', ':status_sent'), $qb->expr()->orX($qb->expr()->eq('e.status', ':status_failed'))))
                        ->setParameter('date', $date->format('Y-m-d H:i:s'))
                        ->setParameter('status_sent', 1)
                        ->setParameter('status_failed', - 1)
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @return Array suscriptions | null
     */
    public function searchInvoicesSentEemails() {
        $qb = $this->createQueryBuilder('e');

        return $qb->where('e.invoiceDocument is NOT NULL')
                        ->andWhere('e.status = :status_sent')
                        ->setParameter('status_sent', 1)
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @return Array suscriptions | null
     */
    public function searchRetentionsSentEemails() {
        $qb = $this->createQueryBuilder('e');

        return $qb->where('e.retentionDocument is NOT NULL')
                        ->andWhere('e.status = :status_sent')
                        ->setParameter('status_sent', 1)
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @return Array suscriptions | null
     */
    public function searchCreditNotesSentEemails() {
        $qb = $this->createQueryBuilder('e');

        return $qb->where('e.creditNoteDocument is NOT NULL')
                        ->andWhere('e.status = :status_sent')
                        ->setParameter('status_sent', 1)
                        ->getQuery()
                        ->getResult();
    }

    /**
     * @return Array suscriptions | null
     */
    public function getEmailSpools() {

        return $this->createQueryBuilder('e')
                        ->where('e.status = :status')
                        ->setParameter('status', 0)
                        ->orderBy('e.createdAt', 'ASC')
                        ->getQuery()
                        ->getResult();
    }

}
