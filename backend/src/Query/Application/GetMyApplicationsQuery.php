<?php

namespace App\Query\Application;

use App\Entity\User;

final readonly class GetMyApplicationsQuery
{
    public function __construct(
        public User $user,
    ) {
    }
}
