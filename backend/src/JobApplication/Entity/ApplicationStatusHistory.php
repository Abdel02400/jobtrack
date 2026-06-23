<?php

namespace App\JobApplication\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\JobApplication\State\ApplicationStatusHistoryProvider;
use App\JobApplication\Enum\ApplicationStatus;
use App\JobApplication\Repository\ApplicationStatusHistoryRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/applications/{id}/history',
            provider: ApplicationStatusHistoryProvider::class,
        ),
    ],
)]
#[ORM\Entity(repositoryClass: ApplicationStatusHistoryRepository::class)]
#[ORM\Table(name: 'applications_status_histories')]
class ApplicationStatusHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applicationStatusHistories')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Application $application;

    #[ORM\Column(enumType: ApplicationStatus::class)]
    private ApplicationStatus $oldStatus;

    #[ORM\Column(enumType: ApplicationStatus::class)]
    private ApplicationStatus $newStatus;

    #[ORM\Column]
    private DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(Application $application): static
    {
        $this->application = $application;

        return $this;
    }

    public function getOldStatus(): ApplicationStatus
    {
        return $this->oldStatus;
    }

    public function setOldStatus(ApplicationStatus $oldStatus): static
    {
        $this->oldStatus = $oldStatus;

        return $this;
    }

    public function getNewStatus(): ApplicationStatus
    {
        return $this->newStatus;
    }

    public function setNewStatus(ApplicationStatus $newStatus): static
    {
        $this->newStatus = $newStatus;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
