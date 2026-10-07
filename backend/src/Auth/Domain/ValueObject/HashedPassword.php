<?php

namespace App\Auth\Domain\ValueObject;

use App\Auth\Domain\Exception\ValueObject\InvalidHashedPasswordException;

final readonly class HashedPassword
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function fromString(string $hashedPassword): self
    {
        $info = password_get_info($hashedPassword);

        if ($info['algo'] === null) {
            throw new InvalidHashedPasswordException();
        }

        return new self($hashedPassword);
    }

    public function value(): string
    {
        return $this->value;
    }
}
