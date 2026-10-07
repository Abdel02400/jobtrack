<?php

namespace App\Shared\UI\Http\EventSubscriber;

use App\Shared\UI\Http\Error\ErrorCatalog;
use App\Shared\UI\Http\Output\ApiErrorOutput;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Transforme toute exception connue du catalogue en réponse API normalisée.
 * Le status et le message proviennent du catalogue ; la forme provient du DTO
 * ApiErrorOutput. Les exceptions inconnues sont laissées au gestionnaire par
 * défaut (500).
 */
final readonly class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ErrorCatalog $catalog,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $error = $this->catalog->forException($event->getThrowable());

        if ($error === null) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                new ApiErrorOutput(message: $error->message),
                $error->status,
            ),
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
