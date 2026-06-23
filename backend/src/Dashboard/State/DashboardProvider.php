<?php

namespace App\Dashboard\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Auth\Entity\User;
use App\Dashboard\Query\GetDashboardQuery;
use App\Dashboard\QueryHandler\GetDashboardQueryHandler;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final readonly class DashboardProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
        private GetDashboardQueryHandler $handler,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedException();
        }

        return $this->handler->handle(
            new GetDashboardQuery($user),
        );
    }
}
