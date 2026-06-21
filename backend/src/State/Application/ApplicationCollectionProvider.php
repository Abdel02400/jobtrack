<?php

namespace App\State\Application;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\Application;
use App\Entity\User;
use App\Query\Application\GetMyApplicationsQuery;
use App\QueryHandler\Application\GetMyApplicationsQueryHandler;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final readonly class ApplicationCollectionProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
        private GetMyApplicationsQueryHandler $handler,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new UnauthorizedHttpException('Bearer', 'You must be authenticated.');
        }

        return ($this->handler)(new GetMyApplicationsQuery($user));
    }
}
