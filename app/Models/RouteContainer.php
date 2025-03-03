<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteContainer extends Model
{
    protected $table = 'route_containers';

    protected $fillable = [
        'route_id',
        'container_type',
        'price'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}

