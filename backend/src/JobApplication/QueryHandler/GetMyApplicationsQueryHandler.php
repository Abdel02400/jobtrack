<?php

namespace App\JobApplication\QueryHandler;

use App\JobApplication\Query\GetMyApplicationsQuery;
use App\JobApplication\Repository\ApplicationRepository;

final readonly class GetMyApplicationsQueryHandler
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
    ) {
    }

    public function __invoke(GetMyApplicationsQuery $query): array
    {
        return $this->applicationRepository->findByFilters(
            user: $query->user,
            status: $query->status,
            company: $query->company,
            page: $query->page,
            itemsPerPage: $query->itemsPerPage,
        );
    }
}
