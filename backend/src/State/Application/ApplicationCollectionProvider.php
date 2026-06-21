<?php

namespace App\State\Application;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use App\Enum\Application\ApplicationStatus;
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

        $status = isset($context['filters']['status'])
        ? ApplicationStatus::tryFrom($context['filters']['status'])
        : null;
        $company = $context['filters']['company'] ?? null;

        return ($this->handler)(
            new GetMyApplicationsQuery(
                user: $user,
                status: $status,
                company: $company,
            ),
        );
    }
}
