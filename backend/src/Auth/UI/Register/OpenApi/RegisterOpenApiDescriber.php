<?php

namespace App\Auth\UI\Register\OpenApi;

use App\Auth\Domain\Exception\User\EmailAlreadyUsedException;
use App\Auth\Domain\Exception\ValueObject\InvalidEmailException;
use App\Auth\Domain\Exception\ValueObject\InvalidPlainPasswordException;
use App\Auth\UI\Http\AuthRoutes;
use App\Auth\UI\OpenApi\AuthOpenApi;
use App\OpenApi\Contract\OpenApiOperationDescriberInterface;
use App\OpenApi\Enum\OpenApiOperationMethod;
use App\OpenApi\ValueObject\OpenApiOperation;
use App\Shared\UI\Http\ApiResponseStatus;
use App\Shared\UI\Http\Exception\InvalidRequestPayloadException;

final class RegisterOpenApiDescriber implements OpenApiOperationDescriberInterface
{
    public function operation(): OpenApiOperation
    {
        return new OpenApiOperation(
            path: AuthRoutes::REGISTER,
            method: OpenApiOperationMethod::POST,
        );
    }

    public function tag(): string
    {
        return AuthOpenApi::TAG;
    }

    public function summary(): string
    {
        return 'Créer un compte utilisateur';
    }

    public function description(): string
    {
        return 'Permet à un utilisateur de créer un compte avec une adresse email et un mot de passe.';
    }

    public function successDescription(): ?string
    {
        return 'Compte utilisateur créé avec succès.';
    }

    public function successExample(): ?array
    {
        return [
            'status' => ApiResponseStatus::OK->value,
        ];
    }

    public function errors(): array
    {
        return [
            EmailAlreadyUsedException::class,
            InvalidEmailException::class,
            InvalidPlainPasswordException::class,
            InvalidRequestPayloadException::class,
        ];
    }

    public function requestExample(): ?array
    {
        return [
            'email' => 'john.doe@example.com',
            'password' => 'Password123!',
        ];
    }
}
