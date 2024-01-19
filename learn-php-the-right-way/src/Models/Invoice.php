<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvoiceStatus;
use App\Model;

class Invoice extends Model
{

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function all(InvoiceStatus $status): array
    {
        return $this
            ->db
            ->createQueryBuilder()
            ->select('id', 'invoice_number', 'amount', 'status')
            ->from('invoices')
            ->where('status=?')
            ->setParameter(0, $status->value)
            ->fetchAllAssociative();
    }

}
