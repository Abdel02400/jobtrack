<?php

namespace App\Security\Voter\Application;

use App\Entity\Application;
use App\Entity\User;
use App\Enum\Security\Application\ApplicationPermission;
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
