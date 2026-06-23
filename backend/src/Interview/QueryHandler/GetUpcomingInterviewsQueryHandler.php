<?php

namespace App\Interview\QueryHandler;

use App\Interview\Dto\UpcomingInterviewOutput;
use App\Interview\Query\GetUpcomingInterviewsQuery;
use App\Interview\Repository\InterviewRepository;

final readonly class GetUpcomingInterviewsQueryHandler
{
    public function __construct(
        private InterviewRepository $interviewRepository,
    ) {
    }

    public function handle(GetUpcomingInterviewsQuery $query): array
    {
        $interviews = $this->interviewRepository->findUpcomingByUser(
            $query->user,
            $query->limit,
        );

        return array_map(
            fn ($interview) => new UpcomingInterviewOutput(
                id: $interview->getId(),
                company: $interview->getApplication()->getCompany(),
                scheduledAt: $interview->getScheduledAt(),
            ),
            $interviews,
        );
    }
}
