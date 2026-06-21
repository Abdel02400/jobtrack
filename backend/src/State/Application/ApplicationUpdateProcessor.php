<?php

namespace App\State\Application;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Application\ApplicationStatusTransitionService;
use App\Entity\Application;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ApplicationUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private ApplicationStatusTransitionService $transitionService,
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

        return $this->persistProcessor->process(
            $data,
            $operation,
            $uriVariables,
            $context
        );
    }
}
