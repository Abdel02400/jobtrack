<?php

namespace App\Shared\UI\Http\Error;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Throwable;

/**
 * Chaque module déclare, via une implémentation de cette interface, la
 * correspondance entre ses exceptions et la réponse d'erreur HTTP associée.
 */
#[AutoconfigureTag('app.error_catalog_contributor')]
interface ErrorCatalogContributorInterface
{
    /**
     * @return array<class-string<Throwable>, ApiError>
     */
    public function errors(): array;
}
