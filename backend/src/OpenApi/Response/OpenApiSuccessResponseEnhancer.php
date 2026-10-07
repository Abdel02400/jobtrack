<?php

namespace App\OpenApi\Response;

use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final readonly class OpenApiSuccessResponseEnhancer
{
    public function __construct(
        private OpenApiResponseExampleUpdater $responseExampleUpdater,
    ) {
    }

    /**
     * @param array<string, mixed>|null $example
     */
    public function enhance(Operation $operation, ?string $description, ?array $example): Operation
    {
        if ($description === null && $example === null) {
            return $operation;
        }

        foreach ($operation->getResponses() ?? [] as $status => $response) {
            if (!$response instanceof Response) {
                continue;
            }

            $statusCode = (int) $status;

            if ($statusCode < HttpResponse::HTTP_OK || $statusCode >= HttpResponse::HTTP_MULTIPLE_CHOICES) {
                continue;
            }

            if ($description !== null) {
                $response = $response->withDescription($description);
            }

            if ($example !== null) {
                $response = $this->responseExampleUpdater->withExample($response, $example);
            }

            $operation = $operation->withResponse((string) $status, $response);
        }

        return $operation;
    }
}
