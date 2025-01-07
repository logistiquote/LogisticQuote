<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'provider',
        'amount',
        'currency',
        'status',
        'order_id',
        'transaction_id',
        'metadata',
        'quotation_id'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];
}
