<?php

namespace App\OpenApi\Factory;

use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\RequestBody;
use App\OpenApi\Http\OpenApiContentType;
use ArrayObject;

final readonly class OpenApiRequestBodyFactory
{
    /**
     * @param array<string, mixed> $example
     */
    public function createFromExample(array $example): RequestBody
    {
        return new RequestBody(
            description: 'Données nécessaires à la requête.',
            content: new ArrayObject([
                OpenApiContentType::JSON => new MediaType(example: $example),
            ]),
            required: true,
        );
    }
}
