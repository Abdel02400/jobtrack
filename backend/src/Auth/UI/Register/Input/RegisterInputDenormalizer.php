<?php

namespace App\Auth\UI\Register\Input;

use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\PlainPassword;
use App\Shared\UI\Http\Exception\InvalidRequestPayloadException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class RegisterInputDenormalizer implements DenormalizerInterface
{
    public function denormalize(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): RegisterInput {
        if (!is_array($data)) {
            throw new InvalidRequestPayloadException();
        }

        return new RegisterInput(
            email: Email::fromString($data['email'] ?? ''),
            password: PlainPassword::fromString($data['password'] ?? ''),
        );
    }

    public function supportsDenormalization(
        mixed $data,
        string $type,
        ?string $format = null,
        array $context = [],
    ): bool {
        return $type === RegisterInput::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            RegisterInput::class => true,
        ];
    }
}
