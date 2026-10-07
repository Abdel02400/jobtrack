<?php

namespace App\OpenApi\Registry;

use ApiPlatform\OpenApi\Model\Tag;
use App\OpenApi\Contract\OpenApiTagDescriberInterface;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final readonly class OpenApiTagRegistry
{
    /**
     * @param iterable<OpenApiTagDescriberInterface> $providers
     */
    public function __construct(
        #[AutowireIterator('app.openapi_tag_provider')]
        private iterable $providers,
    ) {
    }

    /**
     * @return list<Tag>
     */
    public function all(): array
    {
        $tags = [];

        foreach ($this->providers as $provider) {
            if (!$provider instanceof OpenApiTagDescriberInterface) {
                continue;
            }

            $tags[] = $provider->tag();
        }

        return $tags;
    }
}
