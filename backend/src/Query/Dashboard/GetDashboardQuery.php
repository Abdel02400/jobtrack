<?php

namespace App\Query\Dashboard;

use App\Entity\User;

final readonly class GetDashboardQuery
{
    public function __construct(
        public User $user,
    ) {
    }
}
