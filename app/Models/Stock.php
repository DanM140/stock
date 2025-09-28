<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'company',
        'price',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2',
    ];
}
