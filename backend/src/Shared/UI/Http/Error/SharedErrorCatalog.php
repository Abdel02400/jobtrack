<?php

namespace App\Shared\UI\Http\Error;

use App\Shared\UI\Http\Exception\InvalidRequestPayloadException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Erreurs transverses, indépendantes d'un module métier.
 */
final class SharedErrorCatalog implements ErrorCatalogContributorInterface
{
    public function errors(): array
    {
        return [
            InvalidRequestPayloadException::class => new ApiError(
                Response::HTTP_BAD_REQUEST,
                'Le format de la requête est invalide.',
            ),
        ];
    }
}
