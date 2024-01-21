<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'users')]
class User
{

    #[Id, GeneratedValue]
    #[Column(type: Types::INTEGER)]
    private ?int   $id = null;

    #[Column(type: Types::STRING)]
    private string $name;

    /** @var Collection<int,Bug> $reportedBugs */
    #[OneToMany(mappedBy: 'reporter', targetEntity: Bug::class)]
    private Collection $reportedBugs;

    /** @var Collection<int,Bug> $assignedBugs */
    #[OneToMany(mappedBy: 'engineer', targetEntity: Bug::class)]
    private Collection $assignedBugs;

    public function __construct()
    {
        $this->reportedBugs = new ArrayCollection();
        $this->assignedBugs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    public function getReportedBugs(): Collection
    {
        return $this->reportedBugs;
    }

    public function getAssignedBugs(): Collection
    {
        return $this->assignedBugs;
    }

    public function addReportedBug(Bug $bug): void
    {
        $this->reportedBugs[] = $bug;
    }

    public function assignedToBug(Bug $bug): void
    {
        $this->assignedBugs[] = $bug;
    }

}
