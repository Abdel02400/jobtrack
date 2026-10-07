<?php

namespace App\Shared\UI\Http\Error;

/**
 * Source de vérité d'une erreur exposée par l'API : son status HTTP et son
 * message. Consommé à la fois par le runtime (génération de la réponse) et par
 * la documentation OpenAPI (exemples).
 */
final readonly class ApiError
{
    public function __construct(
        public int $status,
        public string $message,
    ) {
    }
}
