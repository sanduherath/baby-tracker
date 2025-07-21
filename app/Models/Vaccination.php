<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccination extends Model
{
    use HasFactory;

    protected $fillable = [
        'baby_id',
        'vaccine_name',
        'dose',
        'date_administered',
        'recommended_age',
        'status',
        'administered_by',
        'clinic_or_hospital',

    ];

    // Define the relationship to the Baby model
    public function baby()
    {
        return $this->belongsTo(Baby::class);
    }
    public function vaccinations()
{
    return $this->hasMany(Vaccination::class);
}


   public function appointment()
    {
        return $this->hasOne(Appointment::class, 'patient_id', 'baby_id')
                    ->where('patient_type', 'baby')
                    ->where('vaccination_type', $this->vaccine_name);
    }
    public function midwife()
    {
        return $this->belongsTo(User::class, 'midwife_id');
    }
}
