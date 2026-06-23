<?php

namespace App\JobApplication\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Auth\Entity\User;
use App\JobApplication\Enum\ApplicationStatus;
use App\JobApplication\Query\GetMyApplicationsQuery;
use App\JobApplication\QueryHandler\GetMyApplicationsQueryHandler;
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
        $page = max(1, (int) ($context['filters']['page'] ?? 1));
        $itemsPerPage = 1;

        return ($this->handler)(
            new GetMyApplicationsQuery(
                user: $user,
                status: $status,
                company: $company,
                page: $page,
                itemsPerPage: $itemsPerPage
            ),
        );
    }
}
