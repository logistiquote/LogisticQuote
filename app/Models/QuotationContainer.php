<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationContainer extends Model
{
    protected $table = 'quotation_containers';

    protected $fillable = [
        'quotation_id',
        'route_container_id',
        'quantity',
        'price_per_container',
        'total_price',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function routeContainer(): BelongsTo
    {
        return $this->belongsTo(RouteContainer::class);
    }
}

