<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Training
{
    #[ORM\Id]
    #[ORM\Column]
    private \DateTimeImmutable $dateTraining;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'trainings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'trainings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $trainee = null;

    #[ORM\Column]
    private bool $visited;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $explanatory = null;

    public function __construct(Team $team, User $user, \DateTimeImmutable $dateTime)
    {
        $this->team = $team;
        $this->trainee = $user;
        $this->dateTraining = $dateTime;
    }

    public function getDateTraining(): \DateTimeImmutable
    {
        return $this->dateTraining;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function getTrainee(): ?User
    {
        return $this->trainee;
    }

    public function isVisited(): bool
    {
        return $this->visited;
    }

    public function setVisited(bool $visited): self
    {
        $this->visited = $visited;

        return $this;
    }

    public function getExplanatory(): ?string
    {
        return $this->explanatory;
    }

    public function setExplanatory(?string $explanatory): self
    {
        $this->explanatory = $explanatory;

        return $this;
    }
}
