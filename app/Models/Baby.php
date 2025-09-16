<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Baby extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'babies';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'gender',
        'birth_date',
        'birth_time',
        'birth_weight',
        'birth_height',
        'head_circumference',
        'current_weight',
        'current_height',
        'blood_group',
        'birth_hospital',
        'delivery_type',
        'gestational_age',
        'registration_number',
        'registered_date',
        'user_id',
        'mother_name',
        'mother_nic',
        'mother_contact',
        'mother_email',
        'father_name',
        'father_contact',
        'address',
        'district',
        'division_id',
        'moh_area',
        'birth_complications',
        'congenital_conditions',
        'bcg_vaccine',
        'opv0_vaccine',
        'hepb_vaccine',
        'additional_notes',
        'midwife_name',
        'midwife_id',
        'midwife_contact',
        'regional_health_division',
        'rh_contact_1',
        'rh_contact_2',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'bcg_vaccine' => 'boolean',
        'opv0_vaccine' => 'boolean',
        'hepb_vaccine' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    ];

    public function getAuthIdentifierName()
    {
        // Return the primary id so Auth::id() returns the baby primary key (used across controllers)
        return 'id';
    }

    public function patient()
    {
        return $this->morphOne(Patient::class, 'patientable');
    }

    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    public function diaries()
    {
        return $this->hasMany(BabyDiary::class, 'baby_id');
    }

    public function midwife()
    {
        return $this->belongsTo(User::class, 'user_id');
        // Note: The second return statement for Midwife::class is unreachable; consider fixing
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id')->where('patient_type', 'baby');
    }

    public function latest_appointment()
    {
        return $this->hasOne(Appointment::class, 'patient_id')
            ->where('patient_type', 'baby')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc');
    }

    public function clinicRecords()
    {
        return $this->morphMany(ClinicRecord::class, 'patientable');
    }

    public function showProfile()
    {
        $baby = Baby::where('user_id', Auth::id())->first();
        return view('baby.dashboard', compact('baby'));
    }

    public function getAgeAttribute()
    {
        return round(Carbon::parse($this->birth_date)->floatDiffInYears(Carbon::now()), 1);
    }

    public function updateMeasurements($data)
    {
        $this->update([
            'current_weight' => $data['weight'] ?? $this->current_weight,
            'current_height' => $data['height'] ?? $this->current_height,
            'head_circumference' => $data['head_circumference'] ?? $this->head_circumference,
        ]);
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($baby) {
            $baby->appointments()->delete();
            $baby->clinicRecords()->delete();
        });
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
