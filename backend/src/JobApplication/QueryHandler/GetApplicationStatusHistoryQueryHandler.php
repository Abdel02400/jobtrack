<?php

namespace App\JobApplication\QueryHandler;

use App\JobApplication\Query\GetApplicationStatusHistoryQuery;
use App\JobApplication\Repository\ApplicationStatusHistoryRepository;

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
