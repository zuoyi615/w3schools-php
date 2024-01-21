<?php

namespace App\Entities;

use App\Enums\BugStatus;
use DateTime;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'bugs')]
class Bug
{

    #[Id, GeneratedValue]
    #[Column(type: Types::INTEGER)]
    private ?int      $id = null;

    #[Column(type: Types::STRING)]
    private string    $description;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime  $createdAt;

    #[Column]
    private BugStatus $status;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'assignedBugs')]
    private User      $engineer;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'reportedBugs')]
    private User      $reporter;

    /** @var Collection<int, Product> $products */
    #[ManyToMany(targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Bug
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Bug
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Bug
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): BugStatus
    {
        return $this->status;
    }

    public function setStatus(BugStatus $status): Bug
    {
        $this->status = $status;

        return $this;
    }

    public function getEngineer(): User
    {
        return $this->engineer;
    }

    public function setEngineer(User $engineer): User
    {
        $this->engineer = $engineer;
        $engineer->assignedToBug($this);

        return $this;
    }

    public function getReporter(): User
    {
        return $this->reporter;
    }

    public function setReporter(User $reporter): User
    {
        $this->reporter = $reporter;
        $reporter->addReportedBug($this);

        return $this;
    }

    public function assignToProduct(Product $product): void
    {
        $this->products = $this->products;
    }

    /** @return Collection<int, Product> */
    public function getProducts(): Collection
    {
        return $this->products;
    }

}
