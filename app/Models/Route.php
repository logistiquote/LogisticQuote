<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Route extends Model
{
    protected $table = 'routes';

    protected $fillable = [
        'origin_id',
        'destination_id',
        'type',
        'price_valid_until',
        'delivery_line',
        'fcl_delivery_time',
        'lcl_delivery_time',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function origin(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'origin_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'destination_id');
    }

    public function containers(): HasMany
    {
        return $this->hasMany(RouteContainer::class);
    }

    public function rate(): HasOne
    {
        return $this->hasOne(RouteRate::class);
    }

    public function getFullOriginLocationAttribute(): string
    {
        return $this->origin ? "{$this->origin->country}, {$this->origin->name}" : 'N/A';
    }

    public function getFullDestinationLocationAttribute(): string
    {
        return $this->destination ? "{$this->destination->country}, {$this->destination->name}" : 'N/A';
    }
}
