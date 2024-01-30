<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int    $id
 * @property int    $invoice_id
 * @property string $description
 * @property int    $quantity
 * @property float  $unit_price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class InvoiceItem extends Model
{

    protected $casts
        = [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

}
