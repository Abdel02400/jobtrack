<?php

namespace App\Query\Application;

use App\Entity\User;
use App\Enum\Application\ApplicationStatus;

final readonly class GetMyApplicationsQuery
{
    public function __construct(
        public User $user,
        public ?ApplicationStatus $status = null,
        public ?string $company = null,
    ) {
    }
}
