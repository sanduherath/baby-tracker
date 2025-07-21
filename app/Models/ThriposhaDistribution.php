<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThriposhaDistribution extends Model
{
    protected $fillable = [
        'date',
        'type',
        'quantity',
        'transaction_type',
        'recipient',
        'recipient_id',
        'notes',
        'status',
        'expected_date',
        'baby_thriposha_quantity',
        'mother_thriposha_quantity',
    ];

    protected $casts = [
        'date' => 'datetime',
        'expected_date' => 'datetime',
    ];

    public function recipient()
    {
        return $this->belongsTo(Patient::class, 'recipient_id');
    }
}
