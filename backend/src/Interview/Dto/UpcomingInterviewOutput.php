<?php

namespace App\Interview\Dto;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Interview\State\UpcomingInterviewCollectionProvider;
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
