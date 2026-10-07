<?php

namespace App\Auth\UI\Register\Input;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\PlainPassword;

final class RegisterInput
{
    public function __construct(
        public Email $email,
        public PlainPassword $password,
    ) {
    }
}
