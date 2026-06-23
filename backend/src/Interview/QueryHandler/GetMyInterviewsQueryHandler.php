<?php

namespace App\Interview\QueryHandler;

use App\Interview\Query\GetMyInterviewsQuery;
use App\Interview\Repository\InterviewRepository;

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
