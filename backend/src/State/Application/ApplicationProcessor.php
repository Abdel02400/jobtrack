<?php

namespace App\State\Application;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Application;
use App\Entity\ApplicationStatusHistory;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ApplicationProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private Security $security,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): mixed {
        if (!$data instanceof Application) {
            throw new \LogicException(
                sprintf(
                    'Expected %s, got %s',
                    Application::class,
                    get_debug_type($data)
                )
            );
        }

        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('Authenticated user expected.');
        }

        $data->setUser($user);

        $status = $data->getStatus();

        $history = new ApplicationStatusHistory();

        $history
            ->setApplication($data)
            ->setOldStatus($status)
            ->setNewStatus($status);

        $this->entityManager->persist($history);

        return $this->persistProcessor->process($data, $operation, $uriVariables, $context);
    }
}
