<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckupMetric extends Model
{
    protected $fillable = [
        'appointment_id',
        'weight',
        'length',
        'head_circumference',
        'temperature',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
