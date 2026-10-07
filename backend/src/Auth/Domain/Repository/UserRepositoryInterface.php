<?php

namespace App\Auth\Domain\Repository;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function existsByEmail(Email $email): bool;
}
