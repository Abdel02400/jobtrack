<?php

namespace App\Dto\Dashboard;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\State\Dashboard\DashboardProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/dashboard',
            provider: DashboardProvider::class,
        ),
    ],
)]
final readonly class DashboardOutput
{
    public function __construct(
        public int $applications,
        public int $interviews,
        public int $offers,
        public int $rejected,
    ) {
    }
}
