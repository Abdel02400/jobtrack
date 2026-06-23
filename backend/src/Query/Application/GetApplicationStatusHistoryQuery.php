<?php

namespace App\Query\Application;

use App\Entity\User;

final readonly class GetApplicationStatusHistoryQuery
{
    public function __construct(
        public int $applicationId,
        public User $user,
    ) {
    }
}
