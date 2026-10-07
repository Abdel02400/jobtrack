<?php

namespace App\Shared\UI\Http\Error;

use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Throwable;

/**
 * Agrège les contributions de chaque module et permet de retrouver l'erreur
 * associée à une exception (runtime) ou à une classe d'exception (doc OpenAPI).
 */
final class ErrorCatalog
{
    /**
     * @var array<class-string<Throwable>, ApiError>
     */
    private array $errors = [];

    /**
     * @param iterable<ErrorCatalogContributorInterface> $contributors
     */
    public function __construct(
        #[AutowireIterator('app.error_catalog_contributor')]
        iterable $contributors,
    ) {
        foreach ($contributors as $contributor) {
            $this->errors += $contributor->errors();
        }
    }

    public function forException(Throwable $exception): ?ApiError
    {
        foreach ($this->errors as $class => $error) {
            if ($exception instanceof $class) {
                return $error;
            }
        }

        return null;
    }

    /**
     * @param class-string<Throwable> $class
     */
    public function forClass(string $class): ?ApiError
    {
        return $this->errors[$class] ?? null;
    }
}
