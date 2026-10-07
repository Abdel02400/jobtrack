<?php

namespace App\OpenApi\Decorator;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\OpenApi;
use App\OpenApi\Documentation\OpenApiPathItemDescriberApplier;
use App\OpenApi\Registry\OpenApiErrorSchemaRegistry;
use App\OpenApi\Registry\OpenApiTagRegistry;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;

#[AsDecorator(decorates: 'api_platform.openapi.factory')]
final readonly class OpenApiFactoryDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        #[AutowireDecorated]
        private OpenApiFactoryInterface $decorated,

        private OpenApiErrorSchemaRegistry $errorSchemaRegistry,
        private OpenApiPathItemDescriberApplier $pathItemDescriberApplier,
        private OpenApiTagRegistry $tagRegistry,
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);

        [$openApi, $errorSchemaReference] = $this->errorSchemaRegistry->register($openApi);

        $paths = $openApi->getPaths();

        foreach ($paths->getPaths() as $path => $pathItem) {
            if (!$pathItem instanceof PathItem) {
                continue;
            }

            $paths->addPath(
                $path,
                $this->pathItemDescriberApplier->apply($path, $pathItem, $errorSchemaReference),
            );
        }

        return $openApi->withTags([
            $this->tagRegistry->all(),
        ]);
    }
}
