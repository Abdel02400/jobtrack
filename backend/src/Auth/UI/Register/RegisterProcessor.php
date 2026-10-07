<?php

namespace App\Auth\UI\Register;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Auth\Application\Register\RegisterUserCommand;
use App\Auth\Application\Register\RegisterUserCommandHandler;
use App\Auth\UI\Register\Input\RegisterInput;
use App\Shared\UI\Http\Output\ApiSuccessOutput;

final readonly class RegisterProcessor implements ProcessorInterface
{
    public function __construct(
        private RegisterUserCommandHandler $handler,
    ) {
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = [],
    ): ApiSuccessOutput {
        /** @var RegisterInput $data */
        ($this->handler)(
            new RegisterUserCommand(
                email: $data->email,
                password: $data->password,
            )
        );

        return new ApiSuccessOutput();
    }
}
