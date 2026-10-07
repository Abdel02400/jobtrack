<?php

namespace App\Shared\UI\Http;

enum ApiResponseStatus: string
{
    case OK = 'Ok';
    case KO = 'Ko';
    case INTERNAL_ERROR = 'InternalError';
}
