<?php

namespace App\OpenApi\Path;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class OpenApiPathNormalizer
{
    public function __construct(
        #[Autowire('%app.api_prefix%')]
        private string $apiPrefix,
    ) {
    }

    public function normalize(string $path): string
    {
        if ($path === $this->apiPrefix) {
            return '/';
        }

        if (!str_starts_with($path, $this->apiPrefix . '/')) {
            return $path;
        }

        return substr($path, strlen($this->apiPrefix));
    }
}
