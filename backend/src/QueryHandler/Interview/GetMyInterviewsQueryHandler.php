<?php

namespace App\QueryHandler\Interview;

use App\Query\Interview\GetMyInterviewsQuery;
use App\Repository\InterviewRepository;

final readonly class GetMyInterviewsQueryHandler
{
    public function __construct(
        private InterviewRepository $interviewRepository,
    ) {
    }

    public function __invoke(GetMyInterviewsQuery $query): array
    {
        return $this->interviewRepository
            ->createQueryBuilder('i')
            ->join('i.application', 'a')
            ->andWhere('a.user = :user')
            ->setParameter('user', $query->user)
            ->orderBy('i.scheduledAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
