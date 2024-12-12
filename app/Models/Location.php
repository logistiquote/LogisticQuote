<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
