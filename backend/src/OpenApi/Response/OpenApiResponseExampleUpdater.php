<?php

namespace App\OpenApi\Response;

use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\Response;
use App\OpenApi\Http\OpenApiContentType;
use ArrayObject;

final readonly class OpenApiResponseExampleUpdater
{
    /**
     * @param array<string, mixed> $example
     */
    public function withExample(Response $response, array $example): Response
    {
        $content = $response->getContent();

        if ($content === null || !isset($content[OpenApiContentType::JSON])) {
            return $response;
        }

        $mediaType = $content[OpenApiContentType::JSON];

        if (!$mediaType instanceof MediaType) {
            return $response;
        }

        $content = new ArrayObject($content->getArrayCopy());
        $content[OpenApiContentType::JSON] = $mediaType->withExample($example);

        return $response->withContent($content);
    }
}
