<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    protected $table = 'shipments';

    protected $fillable = [
        'quotation_id',
        'carrier',
        'service_type',
        'tracking_number',
        'tracking_url',
        'label_url',
        'shipment_data'
    ];

    protected $casts = [
        'shipment_data' => 'array',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function getFullOriginLocationAttribute(): string
    {
        return  "{$this->shipment_data['origin_country']}, {$this->shipment_data['origin_city']}";
    }

    public function getFullDestinationLocationAttribute(): string
    {
        return  "{$this->shipment_data['destination_country']}, {$this->shipment_data['destination_city']}";
    }
}

