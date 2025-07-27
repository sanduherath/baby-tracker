<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', // 'baby' or 'pregnant'
        'district',
        'grama_niladhari_division',
        'moh_area',
        'address',
        'midwife_id',
    ];

    // Define polymorphic relationship for specific patient types
  public function patientable()
    {
        return $this->morphTo();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'patientable_id')
                    ->where('patient_type', $this->type);
    }
}
