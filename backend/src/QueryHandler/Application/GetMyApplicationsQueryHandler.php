<?php

namespace App\QueryHandler\Application;

use App\Query\Application\GetMyApplicationsQuery;
use App\Repository\ApplicationRepository;

final readonly class GetMyApplicationsQueryHandler
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
    ) {
    }

    public function __invoke(GetMyApplicationsQuery $query): array
    {
        return $this->applicationRepository->findBy(
            ['user' => $query->user],
            ['createdAt' => 'DESC']
        );
    }
}
