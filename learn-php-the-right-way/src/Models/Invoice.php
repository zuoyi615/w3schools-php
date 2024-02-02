<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvoiceStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int             $id
 * @property float           $amount
 * @property string          $invoice_number
 * @property InvoiceStatus   $status
 * @property Carbon          $created_at
 * @property Carbon          $updated_at
 * @property Carbon          $due_date
 * @property-read Collection $items
 */
class Invoice extends Model
{

    protected $casts
        = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'status'     => InvoiceStatus::class,
            'due_date'   => 'datetime',
        ];

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            // set default value for due_date if not set value manually
            if ($invoice->isClean('due_date')) {
                $invoice->due_date = (new Carbon())->addDays(10);
            }
        });
    }

}
