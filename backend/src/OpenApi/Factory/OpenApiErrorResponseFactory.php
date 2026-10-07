<?php

namespace App\OpenApi\Factory;

use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\Response;
use App\OpenApi\Http\OpenApiContentType;
use ArrayObject;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

final readonly class OpenApiErrorResponseFactory
{
    public function __construct(
        private OpenApiErrorExampleFactory $errorExampleFactory,
    ) {
    }

    /**
     * @param list<class-string<Throwable>> $errorClasses
     *
     * @return array<int, Response>
     */
    public function createFromExceptions(array $errorClasses, string $errorSchemaReference): array
    {
        $responses = [];

        foreach ($this->errorExampleFactory->createGroupedByStatus($errorClasses) as $status => $examples) {
            $responses[$status] = new Response(
                description: $this->describeStatus($status),
                content: new ArrayObject([
                    OpenApiContentType::JSON => new MediaType(
                        schema: new ArrayObject(['$ref' => $errorSchemaReference]),
                        examples: new ArrayObject($examples),
                    ),
                ]),
            );
        }

        return $responses;
    }

    private function describeStatus(int $status): string
    {
        return match ($status) {
            HttpResponse::HTTP_BAD_REQUEST => 'Requête invalide.',
            HttpResponse::HTTP_UNAUTHORIZED => 'Authentification requise.',
            HttpResponse::HTTP_FORBIDDEN => 'Accès refusé.',
            HttpResponse::HTTP_UNPROCESSABLE_ENTITY => 'Erreur métier lors de la requête.',
            default => 'Erreur.',
        };
    }
}
