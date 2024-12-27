<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationPallet extends Model
{
    protected $table = 'quotation_pallets';

    protected $fillable = [
        'quotation_id',
        'length',
        'width',
        'height',
        'volumetric_weight',
        'gross_weight',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }
}

