<?php

namespace App\Repository;

use App\Entity\Interview;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Interview>
 */
class InterviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interview::class);
    }

    public function countByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('i')
            ->select('COUNT(i.id)')
            ->innerJoin('i.application', 'a')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findUpcomingByUser(User $user, int $limit = 5): array
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.application', 'a')
            ->where('a.user = :user')
            ->andWhere('i.scheduledAt > :now')
            ->setParameter('user', $user)
            ->setParameter('now', new DateTimeImmutable())
            ->orderBy('i.scheduledAt', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Interview[]
     */
    public function findScheduledInNext24Hours(): array
    {
        $now = new DateTimeImmutable();
        $tomorrow = $now->modify('+24 hours');

        return $this->createQueryBuilder('i')
            ->andWhere('i.scheduledAt >= :now')
            ->andWhere('i.scheduledAt <= :tomorrow')
            ->andWhere('i.reminderSentAt IS NULL')
            ->setParameter('now', $now)
            ->setParameter('tomorrow', $tomorrow)
            ->orderBy('i.scheduledAt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Interview[] Returns an array of Interview objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Interview
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
