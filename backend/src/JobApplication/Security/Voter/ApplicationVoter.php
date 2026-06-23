<?php

namespace App\JobApplication\Security\Voter;

use App\JobApplication\Entity\Application;
use App\Auth\Entity\User;
use App\JobApplication\Enum\Security\ApplicationPermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class ApplicationVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array(
            $attribute,
            [
                ApplicationPermission::View->value,
                ApplicationPermission::Edit->value,
                ApplicationPermission::Delete->value,
            ],
            true
        );
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Application $application */
        $application = $subject;

        return $application->getUser() === $user;
    }
}
