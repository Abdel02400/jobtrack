<?php

namespace App\Auth\UI\OpenApi;

use ApiPlatform\OpenApi\Model\Tag;
use App\OpenApi\Contract\OpenApiTagDescriberInterface;

final class AuthOpenApi implements OpenApiTagDescriberInterface
{
    public const TAG = 'Authentification';

    public function tag(): Tag
    {
        return new Tag(
            name: self::TAG,
            description: 'Gestion des comptes utilisateurs, de la connexion et du renouvellement des jetons.'
        );
    }
}
