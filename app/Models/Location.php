<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    protected $table = 'locations';

    protected $fillable = [
        'country',
        'country_code',
        'name',
        'type'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function origins(): HasMany
    {
        return $this->hasMany(Route::class, 'origin_id');
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(Route::class, 'destination_id');
    }

    public function getFullLocationAttribute(): string
    {
        return "$this->country, $this->name";
    }
}
