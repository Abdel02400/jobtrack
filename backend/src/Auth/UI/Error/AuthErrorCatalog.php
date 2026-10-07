<?php

namespace App\Auth\UI\Error;

use App\Auth\Domain\Exception\User\EmailAlreadyUsedException;
use App\Auth\Domain\Exception\ValueObject\InvalidEmailException;
use App\Auth\Domain\Exception\ValueObject\InvalidPlainPasswordException;
use App\Shared\UI\Http\Error\ApiError;
use App\Shared\UI\Http\Error\ErrorCatalogContributorInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Correspondance entre les exceptions métier du module Auth et leurs réponses
 * HTTP. Unique endroit où vivent le status et le message de ces erreurs.
 */
final class AuthErrorCatalog implements ErrorCatalogContributorInterface
{
    public function errors(): array
    {
        return [
            EmailAlreadyUsedException::class => new ApiError(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'Cette adresse email est déjà utilisée.',
            ),
            InvalidEmailException::class => new ApiError(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'L’adresse email est invalide.',
            ),
            InvalidPlainPasswordException::class => new ApiError(
                Response::HTTP_UNPROCESSABLE_ENTITY,
                'Le mot de passe est invalide.',
            ),
        ];
    }
}
