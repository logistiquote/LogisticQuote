<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteRate extends Model
{
    protected $table = 'route_rates';

    protected $fillable = [
        'route_id',
        'ocean_freight',
        'terminal_handling_charges',
        'total_price',
        'min_ocean_freight',
        'destination_charges'
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}
