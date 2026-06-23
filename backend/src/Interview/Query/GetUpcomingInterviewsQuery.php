<?php

namespace App\Interview\Query;

use App\Auth\Entity\User;

final readonly class GetUpcomingInterviewsQuery
{
    public function __construct(
        public User $user,
        public int $limit = 5,
    ) {
    }
}
