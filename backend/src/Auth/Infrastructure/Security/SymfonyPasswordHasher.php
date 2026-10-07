<?php

namespace App\Auth\Infrastructure\Security;

use App\Auth\Domain\Service\PasswordHasherInterface;
use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Domain\ValueObject\PlainPassword;
use App\Auth\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

final readonly class SymfonyPasswordHasher implements PasswordHasherInterface
{
    public function __construct(
        private PasswordHasherFactoryInterface $factory,
    ) {
    }

    public function hash(
        PlainPassword $password,
    ): HashedPassword {
        $hasher = $this->factory->getPasswordHasher(User::class);

        return HashedPassword::fromString(
            $hasher->hash($password->value())
        );
    }
}
