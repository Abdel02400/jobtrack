<?php

namespace App\OpenApi\Contract;

use App\OpenApi\ValueObject\OpenApiOperation;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Throwable;

#[AutoconfigureTag('app.openapi_operation_describer')]
interface OpenApiOperationDescriberInterface
{
    public function operation(): OpenApiOperation;

    public function tag(): string;

    public function summary(): string;

    public function description(): string;

    public function successDescription(): ?string;

    public function successExample(): ?array;

    /**
     * @return list<class-string<Throwable>>
     */
    public function errors(): array;

    public function requestExample(): ?array;
}
