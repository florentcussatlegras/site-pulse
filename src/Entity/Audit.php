<?php

// src/Entity/Audit.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: 'App\Repository\AuditRepository')]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $url;

    #[ORM\Column(type: 'integer')]
    private int $performance;

    #[ORM\Column(type: 'integer')]
    private int $seo;

    #[ORM\Column(type: 'integer')]
    private int $accessibility;

    #[ORM\Column(type: 'integer')]
    private int $bestPractices;

    #[ORM\Column(type: 'json')]
    private array $recommendations = [];

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private \DateTimeImmutable $createdAt;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "audits")]
    #[ORM\JoinColumn(nullable: true)] // nullable pour audits anonymes
    private ?User $user = null;

    public function __construct()
    {
        // Initialise la date de création à maintenant
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUrl(): string
    {
        return $this->url;
    }
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function getPerformance(): int
    {
        return $this->performance;
    }
    public function setPerformance(int $performance): self
    {
        $this->performance = $performance;
        return $this;
    }

    public function getSeo(): int
    {
        return $this->seo;
    }
    public function setSeo(int $seo): self
    {
        $this->seo = $seo;
        return $this;
    }

    public function getAccessibility(): int
    {
        return $this->accessibility;
    }
    public function setAccessibility(int $accessibility): self
    {
        $this->accessibility = $accessibility;
        return $this;
    }

    public function getBestPractices(): int
    {
        return $this->bestPractices;
    }
    public function setBestPractices(int $bestPractices): self
    {
        $this->bestPractices = $bestPractices;
        return $this;
    }

    public function getRecommendations(): array
    {
        return $this->recommendations;
    }
    public function setRecommendations(array $recommendations): self
    {
        $this->recommendations = $recommendations;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
