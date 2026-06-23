<?php

namespace App\Interview\Security\Voter;

use App\Interview\Entity\Interview;
use App\Auth\Entity\User;
use App\Interview\Enum\Security\InterviewPermission;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class InterviewVoter extends Voter
{
    protected function supports(string $attribute, mixed $subject): bool
    {
        return $subject instanceof Interview
            && in_array($attribute, array_column(InterviewPermission::cases(), 'value'), true);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        /** @var Interview $interview */
        $interview = $subject;

        return $interview->getApplication()?->getUser() === $user;
    }
}
