<?php

namespace App\Auth\Domain\ValueObject;

use App\Auth\Domain\Exception\ValueObject\InvalidPlainPasswordException;

final readonly class PlainPassword
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function fromString(string $password): self
    {
        if (strlen($password) < 8) {
            throw new InvalidPlainPasswordException();
        }

        return new self($password);
    }

    public function value(): string
    {
        return $this->value;
    }
}
