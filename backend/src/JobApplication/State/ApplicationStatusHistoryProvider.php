<?php

namespace App\JobApplication\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Auth\Entity\User;
use App\JobApplication\Query\GetApplicationStatusHistoryQuery;
use App\JobApplication\QueryHandler\GetApplicationStatusHistoryQueryHandler;
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
