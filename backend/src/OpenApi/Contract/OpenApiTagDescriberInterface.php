<?php

namespace App\OpenApi\Contract;

use ApiPlatform\OpenApi\Model\Tag;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.openapi_tag_provider')]
interface OpenApiTagDescriberInterface
{
    public function tag(): Tag;
}
