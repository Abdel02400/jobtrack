<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use App\Enum\Application\ApplicationStatus;
use DateTimeImmutable;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'applications')]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $company = null;

    #[Assert\Url]
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $jobUrl = null;

    #[ORM\Column(length: 50, enumType: ApplicationStatus::class)]
    private ?ApplicationStatus $status = ApplicationStatus::Applied;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $appliedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Interview>
     */
    #[ORM\OneToMany(targetEntity: Interview::class, mappedBy: 'application')]
    private Collection $interviews;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->interviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getJobUrl(): ?string
    {
        return $this->jobUrl;
    }

    public function setJobUrl(?string $jobUrl): static
    {
        $this->jobUrl = $jobUrl;

        return $this;
    }

    public function getStatus(): ?ApplicationStatus
    {
        return $this->status;
    }

    public function setStatus(ApplicationStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAppliedAt(): ?DateTimeImmutable
    {
        return $this->appliedAt;
    }

    public function setAppliedAt(?DateTimeImmutable $appliedAt): static
    {
        $this->appliedAt = $appliedAt;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Interview>
     */
    public function getInterviews(): Collection
    {
        return $this->interviews;
    }

    public function addInterview(Interview $interview): static
    {
        if (!$this->interviews->contains($interview)) {
            $this->interviews->add($interview);
            $interview->setApplication($this);
        }

        return $this;
    }

    public function removeInterview(Interview $interview): static
    {
        if ($this->interviews->removeElement($interview)) {
            if ($interview->getApplication() === $this) {
                $interview->setApplication(null);
            }
        }

        return $this;
    }
}
