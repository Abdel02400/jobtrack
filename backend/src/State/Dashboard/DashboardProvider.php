<?php

namespace App\State\Dashboard;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Query\Dashboard\GetDashboardQuery;
use App\QueryHandler\Dashboard\GetDashboardQueryHandler;
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
