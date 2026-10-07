<?php

namespace App\Auth\Domain\Exception\ValueObject;

use DomainException;

final class InvalidEmailException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Invalid email address.');
    }
}
