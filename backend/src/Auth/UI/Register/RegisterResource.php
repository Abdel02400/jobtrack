<?php

namespace App\Auth\UI\Register;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Auth\UI\Http\AuthRoutes;
use App\Auth\UI\Register\Input\RegisterInput;
use App\Auth\UI\Register\RegisterProcessor;
use App\Shared\UI\Http\Output\ApiSuccessOutput;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: AuthRoutes::REGISTER,
            input: RegisterInput::class,
            output: ApiSuccessOutput::class,
            processor: RegisterProcessor::class,
        ),
    ],
)]
final class RegisterResource
{
}
