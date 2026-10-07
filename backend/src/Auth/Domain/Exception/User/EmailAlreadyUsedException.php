<?php

namespace App\Auth\Domain\Exception\User;

use DomainException;

final class EmailAlreadyUsedException extends DomainException
{
    public function __construct()
    {
        parent::__construct('Email is already used.');
    }
}
