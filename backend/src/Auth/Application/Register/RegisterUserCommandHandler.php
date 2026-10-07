<?php

namespace App\Auth\Application\Register;

use App\Auth\Domain\Exception\User\EmailAlreadyUsedException;
use App\Auth\Domain\Factory\UserFactory;
use App\Auth\Domain\Repository\UserRepositoryInterface;
use App\Auth\Domain\Service\PasswordHasherInterface;
use App\Auth\Entity\User;

final readonly class RegisterUserCommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserFactory $userFactory,
        private PasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): User
    {
        if ($this->userRepository->existsByEmail($command->email)) {
            throw new EmailAlreadyUsedException();
        }

        $hashedPassword = $this->passwordHasher->hash($command->password);

        $user = $this->userFactory->create(
            $command->email,
            $hashedPassword,
        );

        $this->userRepository->save($user);

        return $user;
    }
}
