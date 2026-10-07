<?php

namespace App\OpenApi\Documentation;

use ApiPlatform\OpenApi\Model\PathItem;
use App\OpenApi\Enum\OpenApiOperationMethod;

final readonly class OpenApiPathItemDescriberApplier
{
    public function __construct(
        private OpenApiOperationDescriberApplier $operationDescriberApplier,
    ) {
    }

    public function apply(
        string $path,
        PathItem $pathItem,
        string $errorSchemaReference,
    ): PathItem {
        foreach (OpenApiOperationMethod::cases() as $method) {
            $operation = $method->extractOperation($pathItem);

            if ($operation === null) {
                continue;
            }

            $operation = $this->operationDescriberApplier->apply(
                path: $path,
                method: $method,
                operation: $operation,
                errorSchemaReference: $errorSchemaReference,
            );

            $pathItem = $method->replaceOperation($pathItem, $operation);
        }

        return $pathItem;
    }
}
