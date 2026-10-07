<?php

namespace App\OpenApi\Enum;

use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use Symfony\Component\HttpFoundation\Request;

enum OpenApiOperationMethod: string
{
    case GET = Request::METHOD_GET;
    case POST = Request::METHOD_POST;
    case PUT = Request::METHOD_PUT;
    case PATCH = Request::METHOD_PATCH;
    case DELETE = Request::METHOD_DELETE;

    public function extractOperation(PathItem $pathItem): ?Operation
    {
        return match ($this) {
            self::GET => $pathItem->getGet(),
            self::POST => $pathItem->getPost(),
            self::PUT => $pathItem->getPut(),
            self::PATCH => $pathItem->getPatch(),
            self::DELETE => $pathItem->getDelete(),
        };
    }

    public function replaceOperation(
        PathItem $pathItem,
        Operation $operation,
    ): PathItem {
        return match ($this) {
            self::GET => $pathItem->withGet($operation),
            self::POST => $pathItem->withPost($operation),
            self::PUT => $pathItem->withPut($operation),
            self::PATCH => $pathItem->withPatch($operation),
            self::DELETE => $pathItem->withDelete($operation),
        };
    }
}
