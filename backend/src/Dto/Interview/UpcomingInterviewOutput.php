<?php

namespace App\Dto\Interview;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\State\Interview\UpcomingInterviewCollectionProvider;
use DateTimeInterface;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/interviews/upcoming',
            provider: UpcomingInterviewCollectionProvider::class,
        ),
    ],
)]
final readonly class UpcomingInterviewOutput
{
    public function __construct(
        public int $id,
        public string $company,
        public DateTimeInterface $scheduledAt,
    ) {
    }
}
