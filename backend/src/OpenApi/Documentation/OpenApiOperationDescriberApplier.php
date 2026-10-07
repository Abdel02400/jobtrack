<?php

namespace App\OpenApi\Documentation;

use ApiPlatform\OpenApi\Model\Operation;
use App\OpenApi\Contract\OpenApiOperationDescriberInterface;
use App\OpenApi\Enum\OpenApiOperationMethod;
use App\OpenApi\Factory\OpenApiErrorResponseFactory;
use App\OpenApi\Factory\OpenApiRequestBodyFactory;
use App\OpenApi\Path\OpenApiPathNormalizer;
use App\OpenApi\Response\OpenApiSuccessResponseEnhancer;
use App\OpenApi\ValueObject\OpenApiOperation;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class OpenApiOperationDescriberApplier
{
    /**
     * @param iterable<OpenApiOperationDescriberInterface> $describers
     */
    public function __construct(
        #[AutowireIterator('app.openapi_operation_describer')]
        private iterable $describers,
        private OpenApiPathNormalizer $pathNormalizer,
        private OpenApiRequestBodyFactory $requestBodyFactory,
        private OpenApiSuccessResponseEnhancer $successResponseEnhancer,
        private OpenApiErrorResponseFactory $errorResponseFactory,
    ) {
    }

    public function apply(
        string $path,
        OpenApiOperationMethod $method,
        Operation $operation,
        string $errorSchemaReference,
    ): Operation {
        $currentOperation = new OpenApiOperation(
            path: $this->pathNormalizer->normalize($path),
            method: $method,
        );

        foreach ($this->describers as $describer) {
            if (!$describer instanceof OpenApiOperationDescriberInterface) {
                continue;
            }

            if (!$describer->operation()->equals($currentOperation)) {
                continue;
            }

            $operation = $operation
                ->withTags([$describer->tag()])
                ->withSummary($describer->summary())
                ->withDescription($describer->description());

            $requestExample = $describer->requestExample();

            if ($requestExample !== null) {
                $operation = $operation->withRequestBody(
                    $this->requestBodyFactory->createFromExample($requestExample),
                );
            }

            $operation = $this->successResponseEnhancer->enhance(
                $operation,
                $describer->successDescription(),
                $describer->successExample(),
            );

            foreach ($this->errorResponseFactory->createFromExceptions($describer->errors(), $errorSchemaReference) as $status => $response) {
                $operation = $operation->withResponse((string) $status, $response);
            }
        }

        return $operation;
    }
}
