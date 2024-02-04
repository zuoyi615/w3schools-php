<?php

namespace App\Entities;

use App\Enums\InvoiceStatus;
use DateTime;
use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column,
    Entity,
    GeneratedValue,
    HasLifecycleCallbacks,
    Id,
    OneToMany,
    PrePersist,
    Table};
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * # Entity
 * - should not be final Class
 * - should not be final Method
 */
#[Entity]
#[Table('invoices')]
#[HasLifecycleCallbacks]
class Invoice
{

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    #[Id]
    #[Column, GeneratedValue]
    private int           $id;

    #[Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private float         $amount;

    #[Column(name: 'invoice_number')]
    private string        $invoiceNumber;

    #[Column]
    private InvoiceStatus $status;

    #[Column(name: 'created_at')]
    private DateTime      $createdAt;

    #[Column(name: 'updated_at', type: Types::DATETIME_MUTABLE)]
    private DateTime      $updatedAt;

    #[Column(name: 'due_date', type: Types::DATETIME_MUTABLE)]
    private DateTime      $dueDate;

    #[OneToMany(
        mappedBy: 'invoice',
        targetEntity: InvoiceItem::class,
        cascade: [
            'persist', 'remove',
        ]
    )]
    private Collection $items;

    #[PrePersist]
    public function onPrePersist(LifecycleEventArgs $args): void
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Invoice
    {
        $this->id = $id;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): Invoice
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInvoiceNumber(): string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(string $invoiceNumber): Invoice
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    public function getStatus(): InvoiceStatus
    {
        return $this->status;
    }

    public function setStatus(InvoiceStatus $status): Invoice
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Invoice
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): Invoice
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): Invoice
    {
        $this->items = $items;

        return $this;
    }

    public function addItem(InvoiceItem $item): static
    {
        $item->setInvoice($this);
        $this->items->add($item);

        return $this;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function setDueDate(DateTime $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

}
