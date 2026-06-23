<?php

namespace App\JobApplication\Repository;

use App\JobApplication\Entity\Application;
use App\Auth\Entity\User;
use App\JobApplication\Enum\ApplicationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function countByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countOffersByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.user = :user')
            ->andWhere('a.status = :status')
            ->setParameter('user', $user)
            ->setParameter('status', ApplicationStatus::Offer)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countRejectedByUser(User $user): int
    {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.user = :user')
            ->andWhere('a.status = :status')
            ->setParameter('user', $user)
            ->setParameter('status', ApplicationStatus::Rejected)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findByFilters(
        User $user,
        ?ApplicationStatus $status,
        ?string $company,
        int $page,
        int $itemsPerPage,
    ): array {
        $qb = $this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->orderBy('a.createdAt', 'DESC');

        if ($status !== null) {
            $qb
                ->andWhere('a.status = :status')
                ->setParameter('status', $status);
        }

        if ($company !== null && trim($company) !== '') {
            $qb
                ->andWhere('LOWER(a.company) LIKE :company')
                ->setParameter('company', '%' . mb_strtolower(trim($company)) . '%');
        }

        $offset = ($page - 1) * $itemsPerPage;

        return $qb
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage)
            ->getQuery()
            ->getResult();
    }

    public function countByStatusForUser(User $user): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.status AS status')
            ->addSelect('COUNT(a.id) AS total')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->groupBy('a.status')
            ->getQuery()
            ->getArrayResult();
    }

    //    /**
    //     * @return Application[] Returns an array of Application objects
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

    //    public function findOneBySomeField($value): ?Application
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
