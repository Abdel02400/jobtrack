<?php

namespace App\QueryHandler\Application;

use App\Query\Application\GetApplicationStatusHistoryQuery;
use App\Repository\ApplicationStatusHistoryRepository;

final readonly class GetApplicationStatusHistoryQueryHandler
{
    public function __construct(
        private ApplicationStatusHistoryRepository $repository,
    ) {
    }

    public function __invoke(GetApplicationStatusHistoryQuery $query): array
    {
        return $this->repository->findByApplicationForUser(
            $query->applicationId,
            $query->user,
        );
    }
}
