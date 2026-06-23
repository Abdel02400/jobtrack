<?php

namespace App\Dashboard\Query;

use App\Auth\Entity\User;

final readonly class GetDashboardQuery
{
    public function __construct(
        public User $user,
    ) {
    }
}
