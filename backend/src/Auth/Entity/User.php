<?php

namespace App\Auth\Entity;

use App\Auth\Domain\Enum\UserRole;
use App\Auth\Domain\ValueObject\Email;
use App\Auth\Domain\ValueObject\HashedPassword;
use App\Auth\Infrastructure\Persistence\DoctrineUserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: DoctrineUserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private string $email;

    #[ORM\Column]
    private string $password;

    #[ORM\Column]
    private array $roles;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct(
        Email $email,
        HashedPassword $password,
    ) {
        $this->email = $email->value();
        $this->password = $password->value();
        $this->roles = [UserRole::USER->value];
        $this->createdAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function refreshUpdatedAt(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return Email::fromString($this->email);
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email->value();
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function changePassword(HashedPassword $password): void
    {
        $this->password = $password->value();
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail()->value();
    }

    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function grantRole(UserRole $role): void
    {
        if (!in_array($role->value, $this->roles, true)) {
            $this->roles[] = $role->value;
        }
    }

    public function hasRole(UserRole $role): bool
    {
        return in_array($role->value, $this->roles, true);
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function eraseCredentials(): void
    {
        // No temporary sensitive data stored on the entity.
    }
}
