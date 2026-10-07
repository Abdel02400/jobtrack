<?php

namespace App\Auth\Domain\Exception\ValueObject;

use DomainException;

final class InvalidPlainPasswordException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Invalid password.');
    }
}
