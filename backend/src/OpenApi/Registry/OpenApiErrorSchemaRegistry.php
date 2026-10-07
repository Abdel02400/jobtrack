<?php

namespace App\OpenApi\Registry;

use ApiPlatform\JsonSchema\Schema;
use ApiPlatform\JsonSchema\SchemaFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use App\Shared\UI\Http\Output\ApiErrorOutput;
use ArrayObject;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

final readonly class OpenApiErrorSchemaRegistry
{
    public function __construct(
        private SchemaFactoryInterface $schemaFactory,
    ) {
    }

    /**
     * @return array{0: OpenApi, 1: string}
     */
    public function register(OpenApi $openApi): array
    {
        $schema = $this->buildErrorSchema();

        $components = $openApi->getComponents();
        $schemas = $components->getSchemas() ?? new ArrayObject();

        foreach ($schema->getDefinitions() as $name => $definition) {
            $schemas[$name] = $definition;
        }

        return [
            $openApi->withComponents($components->withSchemas($schemas)),
            $this->registeredSchemaReference($schema)
        ];
    }

    private function buildErrorSchema(): Schema
    {
        return $this->schemaFactory->buildSchema(
            ApiErrorOutput::class,
            JsonEncoder::FORMAT,
            Schema::TYPE_OUTPUT,
            null,
            new Schema(Schema::VERSION_OPENAPI),
        );
    }

    private function registeredSchemaReference(Schema $schema): string
    {
        $reference = $schema['$ref'];

        return $reference;
    }
}
