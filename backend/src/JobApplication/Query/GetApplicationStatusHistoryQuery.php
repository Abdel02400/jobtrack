<?php

namespace App\JobApplication\Query;

use App\Auth\Entity\User;

final readonly class GetApplicationStatusHistoryQuery
{
    public function __construct(
        public int $applicationId,
        public User $user,
    ) {
    }
}
