<?php

namespace App\Interview\Query;

use App\Auth\Entity\User;

final readonly class GetMyInterviewsQuery
{
    public function __construct(
        public User $user,
    ) {
    }
}
