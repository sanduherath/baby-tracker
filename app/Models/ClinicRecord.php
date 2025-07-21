<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicRecord extends Model
{
    protected $table = 'clinic_records';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'patient_type',
        'weight',
        'height',
        'head_circumference',
        'nutrition',
        'vaccination_name',
        'midwife_accommodations',
    ];

    /**
     * Get the appointment associated with the clinic record.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }
}
