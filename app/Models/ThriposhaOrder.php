<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThriposhaOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_date',
        'type',
        'quantity',
        'urgency',
        'notes',
        'status',
        'expected_delivery_date',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
    ];
}
