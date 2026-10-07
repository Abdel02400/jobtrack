<?php

namespace App\Auth\Domain\Exception\ValueObject;

use DomainException;

final class InvalidHashedPasswordException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Invalid hashed password.');
    }
}
