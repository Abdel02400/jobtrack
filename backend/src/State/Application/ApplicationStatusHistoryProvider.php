<?php

namespace App\State\Application;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Query\Application\GetApplicationStatusHistoryQuery;
use App\QueryHandler\Application\GetApplicationStatusHistoryQueryHandler;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class ApplicationStatusHistoryProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
        private GetApplicationStatusHistoryQueryHandler $queryHandler,
    ) {
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): array {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('Authenticated user expected.');
        }

        $applicationId = (int) $uriVariables['id'];

        return ($this->queryHandler)(
            new GetApplicationStatusHistoryQuery(
                applicationId: $applicationId,
                user: $user,
            )
        );
    }
}
