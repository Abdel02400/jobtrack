<?php

namespace App\Query\Interview;

use App\Entity\User;

final readonly class GetMyInterviewsQuery
{
    public function __construct(
        public User $user,
    ) {
    }
}
