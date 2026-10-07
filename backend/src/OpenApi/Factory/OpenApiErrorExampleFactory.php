<?php

namespace App\OpenApi\Factory;

use ApiPlatform\OpenApi\Model\Example;
use App\Shared\UI\Http\ApiResponseStatus;
use App\Shared\UI\Http\Error\ErrorCatalog;
use ReflectionClass;
use Throwable;

final readonly class OpenApiErrorExampleFactory
{
    public function __construct(
        private ErrorCatalog $catalog,
    ) {
    }

    /**
     * @param list<class-string<Throwable>> $errorClasses
     *
     * @return array<int, array<string, Example>>
     */
    public function createGroupedByStatus(array $errorClasses): array
    {
        $examplesByStatus = [];

        foreach ($errorClasses as $errorClass) {
            $error = $this->catalog->forClass($errorClass);

            if ($error === null) {
                continue;
            }

            $exampleName = (new ReflectionClass($errorClass))->getShortName();

            $examplesByStatus[$error->status][$exampleName] = new Example(
                value: [
                    'status' => ApiResponseStatus::KO->value,
                    'message' => $error->message,
                ],
            );
        }

        return $examplesByStatus;
    }
}
