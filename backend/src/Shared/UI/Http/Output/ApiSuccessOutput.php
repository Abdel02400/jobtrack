<?php

namespace App\Shared\UI\Http\Output;

use App\Shared\UI\Http\ApiResponseStatus;

final readonly class ApiSuccessOutput
{
    public function __construct(
        public ApiResponseStatus $status = ApiResponseStatus::OK,
    ) {
    }
}
