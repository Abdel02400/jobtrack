<?php

namespace App\State\Interview;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Query\Interview\GetMyInterviewsQuery;
use App\QueryHandler\Interview\GetMyInterviewsQueryHandler;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

final readonly class InterviewCollectionProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
        private GetMyInterviewsQueryHandler $handler,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new AccessDeniedHttpException('You must be authenticated.');
        }

        return ($this->handler)(new GetMyInterviewsQuery($user));
    }
}
