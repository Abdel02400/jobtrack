<?php

namespace App\Security\Voter\Interview;

use App\Entity\Interview;
use App\Entity\User;
use App\Enum\Security\Interview\InterviewPermission;
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
