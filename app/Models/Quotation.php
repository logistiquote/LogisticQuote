<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quotation extends Model
{
    protected $table = 'quotations';

    protected $fillable = [
        'user_id',
        'route_id',
        'quote_number',
        'status',
        'type',
        'transportation_type',
        'ready_to_load_date',
        'incoterms',
        'pickup_address',
        'destination_address',
        'value_of_goods',
        'description_of_goods',
        'is_stockable',
        'is_dgr',
        'is_clearance_req',
        'insurance',
        'insurance_price',
        'attachment',
        'quantity',
        'total_weight',
        'total_price',
        'is_paid',
        'remarks',
    ];

    protected array $dates = [
        'ready_to_load_date',
        'created_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function containers(): HasMany
    {
        return $this->hasMany(QuotationContainer::class);
    }

    public function pallets(): HasMany
    {
        return $this->hasMany(QuotationPallet::class);
    }
}
