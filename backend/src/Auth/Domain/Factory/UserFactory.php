<?php

namespace App\Auth\Domain\Factory;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Entity\User;

final readonly class UserFactory
{
    public function create(
        Email $email,
        HashedPassword $password,
    ): User {
        return new User(
            email: $email,
            password: $password,
        );
    }
}
