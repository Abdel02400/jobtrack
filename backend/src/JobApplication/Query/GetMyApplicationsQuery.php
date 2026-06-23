<?php

namespace App\JobApplication\Query;

use App\Auth\Entity\User;
use App\JobApplication\Enum\ApplicationStatus;

final readonly class GetMyApplicationsQuery
{
    public function __construct(
        public User $user,
        public ?ApplicationStatus $status = null,
        public ?string $company = null,
        public int $page = 1,
        public int $itemsPerPage = 10,
    ) {
    }
}
