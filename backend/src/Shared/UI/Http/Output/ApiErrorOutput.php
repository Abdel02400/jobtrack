<?php

namespace App\Shared\UI\Http\Output;

use App\Shared\UI\Http\ApiResponseStatus;

final readonly class ApiErrorOutput
{
    public ApiResponseStatus $status;

    public function __construct(
        public string $message,
    ) {
        $this->status = ApiResponseStatus::KO;
    }
}
