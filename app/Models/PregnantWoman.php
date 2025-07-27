<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PregnantWoman extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nic',
        'dob',
        'contact',
        'email',
        'occupation',
        'husband_name',
        'husband_contact',
        'address',
        'grama_niladhari_division',
        'district',
        'moh_area',
        'lmp_date',
        'edd_date',
        'gravida',
        'para',
        'abortions',
        'living_children',
        'previous_complications',
        'current_complications',
        'diabetes',
        'hypertension',
        'asthma',
        'heart_disease',
        'thyroid',
        'other_condition',
        'other_medical_info',
        'password',
        'midwife_name',
        'current_weight',
        'current_bmi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    ];

    public function patient()
    {
        return $this->morphOne(Patient::class, 'patientable');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id')->where('patient_type', 'pregnant');
    }

    public function clinicRecords()
    {
        return $this->morphMany(ClinicRecord::class, 'patientable');
    }

    public function getAgeAttribute()
    {
        return round(Carbon::parse($this->dob)->floatDiffInYears(Carbon::now()), 1);
    }

    public function updateMeasurements($data)
    {
        $this->update([
            'current_weight' => $data['weight'] ?? $this->current_weight,
            'current_bmi' => $data['bmi'] ?? $this->current_bmi,
        ]);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($pregnantWoman) {
            $pregnantWoman->appointments()->delete();
            $pregnantWoman->clinicRecords()->delete();
        });
    }
    public function latest_appointment()
    {
        return $this->hasOne(Appointment::class, 'patient_id')
            ->where('patient_type', 'pregnant')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
    }
    public function midwife()
    {
        return $this->belongsTo(Midwife::class);
    }
    public function pregnantWomen()
{
    return $this->hasMany(PregnantWoman::class);
}
}
