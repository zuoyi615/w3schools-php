<?php

namespace App\Entities;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\{Column, Entity, GeneratedValue, Id, ManyToOne, Table};

/**
 * # Bidirectional Relationship
 * - Owning: owns or holds the foreign key, Example: invoiceId, ManyToOne is
 * always owning side
 * - Inverse: OneToMany is always inverse side
 */
#[Entity]
#[Table('invoice_items')]
class InvoiceItem
{

    #[Id]
    #[Column, GeneratedValue]
    private int      $id;

    #[Column(name: 'invoice_id')]
    private int      $invoiceId;

    #[Column]
    private string   $description;

    #[Column]
    private int      $quantity;

    #[Column(name: 'unit_price', type: Types::DECIMAL, precision: 10, scale: 2)]
    private float    $unitPrice;

    #[Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    #[Column(name: 'updated_at')]
    private DateTime $updatedAt;

    // #[ManyToOne(targetEntity: Invoice::class, inversedBy: 'items')]
    #[ManyToOne(inversedBy: 'items')]
    private Invoice $invoice;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): InvoiceItem
    {
        $this->id = $id;

        return $this;
    }

    public function getInvoiceId(): int
    {
        return $this->invoiceId;
    }

    public function setInvoiceId(int $invoiceId): InvoiceItem
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): InvoiceItem
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): InvoiceItem
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): InvoiceItem
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): InvoiceItem
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): InvoiceItem
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): InvoiceItem
    {
        $this->invoice = $invoice;

        return $this;
    }

}
