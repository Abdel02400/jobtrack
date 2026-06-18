<?php

namespace App\Entity;

use App\Repository\InterviewRepository;
use App\Enum\Interview\InterviewType;
use DateTimeImmutable;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    normalizationContext: ['groups' => ['interview:read']],
    denormalizationContext: ['groups' => ['interview:write']]
)]
#[ORM\Entity(repositoryClass: InterviewRepository::class)]
#[ORM\Table(name: 'interviews')]
class Interview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['interview:read'])]
    private ?int $id = null;

    #[Assert\NotNull]
    #[ORM\Column]
    #[Groups(['interview:read', 'interview:write'])]
    private ?DateTimeImmutable $scheduledAt = null;

    #[ORM\Column(length: 50, enumType: InterviewType::class)]
    #[Groups(['interview:read', 'interview:write'])]
    private ?InterviewType $type = InterviewType::Video;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['interview:read', 'interview:write'])]
    private ?string $notes = null;

    #[ORM\Column]
    #[Groups(['interview:read'])]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['interview:read'])]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'interviews')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['interview:read', 'interview:write'])]
    private ?Application $application = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScheduledAt(): ?DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(DateTimeImmutable $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getType(): ?InterviewType
    {
        return $this->type;
    }

    public function setType(InterviewType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getApplication(): ?Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): static
    {
        $this->application = $application;

        return $this;
    }
}
