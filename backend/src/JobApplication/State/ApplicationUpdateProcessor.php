<?php

namespace App\JobApplication\State;

use App\JobApplication\Entity\ApplicationStatusHistory;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\JobApplication\Domain\ApplicationStatusTransitionService;
use App\JobApplication\Entity\Application;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ApplicationUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private ApplicationStatusTransitionService $transitionService,
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
            throw new \LogicException(sprintf(
                'Expected %s, got %s.',
                Application::class,
                get_debug_type($data)
            ));
        }

        $previousData = $context['previous_data'] ?? null;

        if (!$previousData instanceof Application) {
            throw new \LogicException('Previous application data expected.');
        }

        $previousStatus = $previousData->getStatus();
        $newStatus = $data->getStatus();

        if ($previousStatus !== null && $newStatus !== null) {
            $this->transitionService->assertCanTransition(
                $previousStatus,
                $newStatus,
            );
        }

        if ($previousStatus !== null && $newStatus !== null && $previousStatus !== $newStatus) {
            $history = new ApplicationStatusHistory();
            $history
                ->setApplication($data)
                ->setOldStatus($previousStatus)
                ->setNewStatus($newStatus);

            $this->entityManager->persist($history);
        }

        return $this->persistProcessor->process(
            $data,
            $operation,
            $uriVariables,
            $context
        );
    }
}
