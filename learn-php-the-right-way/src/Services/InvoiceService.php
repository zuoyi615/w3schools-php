<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Invoice;
use App\Enums\InvoiceStatus;
use Doctrine\ORM\EntityManager;

readonly class InvoiceService
{

    public function __construct(private EntityManager $em) {}

    public function getPaidInvoices(): array
    {
        return $this
            ->em
            ->createQueryBuilder()
            ->select('i')
            ->from(Invoice::class, 'i')
            ->where('i.status = :status')
            ->setParameter('status', InvoiceStatus::Paid)
            ->getQuery()
            ->getArrayResult();
    }

}
