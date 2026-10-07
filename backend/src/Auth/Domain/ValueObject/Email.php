<?php

namespace App\Auth\Domain\ValueObject;

use App\Auth\Domain\Exception\ValueObject\InvalidEmailException;

final readonly class Email
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function fromString(string $email): self
    {
        $email = strtolower($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException();
        }

        return new self($email);
    }

    public function value(): string
    {
        return $this->value;
    }
}
