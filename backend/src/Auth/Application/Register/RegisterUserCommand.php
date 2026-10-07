<?php

namespace App\Auth\Application\Register;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\PlainPassword;

final readonly class RegisterUserCommand
{
    public function __construct(
        public Email $email,
        public PlainPassword $password,
    ) {
    }
}
