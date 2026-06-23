<?php

namespace App\Interview\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Auth\Entity\User;
use App\Interview\Query\GetUpcomingInterviewsQuery;
use App\Interview\QueryHandler\GetUpcomingInterviewsQueryHandler;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final readonly class UpcomingInterviewCollectionProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
        private GetUpcomingInterviewsQueryHandler $handler,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): array {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedException();
        }

        return $this->handler->handle(
            new GetUpcomingInterviewsQuery($user),
        );
    }
}
