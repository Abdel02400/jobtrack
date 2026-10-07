<?php

namespace App\OpenApi\ValueObject;

use App\OpenApi\Enum\OpenApiOperationMethod;

final readonly class OpenApiOperation
{
    public function __construct(
        public string $path,
        public OpenApiOperationMethod $method,
    ) {
    }

    public function equals(self $other): bool
    {
        return $this->path === $other->path
            && $this->method === $other->method;
    }
}
