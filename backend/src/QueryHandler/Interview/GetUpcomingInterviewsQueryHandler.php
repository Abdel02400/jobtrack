<?php

namespace App\QueryHandler\Interview;

use App\Dto\Interview\UpcomingInterviewOutput;
use App\Query\Interview\GetUpcomingInterviewsQuery;
use App\Repository\InterviewRepository;

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
