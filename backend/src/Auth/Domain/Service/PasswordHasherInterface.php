<?php

namespace App\Auth\Domain\Service;

use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Domain\ValueObject\PlainPassword;

interface PasswordHasherInterface
{
    public function hash(
        PlainPassword $password,
    ): HashedPassword;
}
