<?php

namespace App\Dashboard\QueryHandler;

use App\Dashboard\Dto\DashboardOutput;
use App\Dashboard\Query\GetDashboardQuery;
use App\JobApplication\Repository\ApplicationRepository;
use App\Interview\Repository\InterviewRepository;

final readonly class GetDashboardQueryHandler
{
    public function __construct(
        private ApplicationRepository $applicationRepository,
        private InterviewRepository $interviewRepository,
    ) {
    }

    public function handle(GetDashboardQuery $query): DashboardOutput
    {
        $statusSummary = [
            'applied' => 0,
            'screening' => 0,
            'interview' => 0,
            'offer' => 0,
            'rejected' => 0,
        ];

        foreach ($this->applicationRepository->countByStatusForUser($query->user) as $row) {
            $statusSummary[$row['status']->value] = (int) $row['total'];
        }

        return new DashboardOutput(
            applications: $this->applicationRepository->countByUser($query->user),
            interviews: $this->interviewRepository->countByUser($query->user),
            offers: $this->applicationRepository->countOffersByUser($query->user),
            rejected: $this->applicationRepository->countRejectedByUser($query->user),
            statusSummary: $statusSummary,
        );
    }
}
