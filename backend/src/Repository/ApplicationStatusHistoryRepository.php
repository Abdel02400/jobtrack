<?php

namespace App\Repository;

use App\Entity\ApplicationStatusHistory;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplicationStatusHistory>
 */
class ApplicationStatusHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationStatusHistory::class);
    }

    public function findByApplicationForUser(int $applicationId, User $user): array
    {
        return $this->createQueryBuilder('history')
            ->join('history.application', 'application')
            ->andWhere('application.id = :applicationId')
            ->andWhere('application.user = :user')
            ->setParameter('applicationId', $applicationId)
            ->setParameter('user', $user)
            ->orderBy('history.createdAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return ApplicationStatusHistory[] Returns an array of ApplicationStatusHistory objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ApplicationStatusHistory
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
