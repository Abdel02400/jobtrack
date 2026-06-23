<?php

namespace App\Auth\Dto;

use App\Auth\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(
    fields: ['email'],
    entityClass: User::class,
    message: 'Un compte existe déjà avec cette adresse email.'
)]
final class RegisterInput
{
    #[Groups(['register:write'])]
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Groups(['register:write'])]
    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    public string $password;
}
