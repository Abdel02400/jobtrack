<?php

namespace App\QueryHandler\Dashboard;

use App\Dto\Dashboard\DashboardOutput;
use App\Query\Dashboard\GetDashboardQuery;
use App\Repository\ApplicationRepository;
use App\Repository\InterviewRepository;

final readonly class GetDashboardQueryHandler
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private InterviewRepository $interviewRepository,
    ) {
    }

    public function handle(GetDashboardQuery $query): DashboardOutput
    {
        return new DashboardOutput(
            applications: $this->applicationRepository->countByUser($query->user),
            interviews: $this->interviewRepository->countByUser($query->user),
            offers: $this->applicationRepository->countOffersByUser($query->user),
            rejected: $this->applicationRepository->countRejectedByUser($query->user),
        );
    }
}
