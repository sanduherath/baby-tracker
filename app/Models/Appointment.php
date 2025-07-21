<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_type',
        'patient_id',
        'midwife_id',
        'date',
        'time',
        'type',
        'vaccination_type',
        'notes',
        'status',
    ];

    public function midwife()
    {
        return $this->belongsTo(Midwife::class);
    }

public function patient()
{
    if ($this->patient_type === 'baby') {
        return $this->belongsTo(Baby::class, 'patient_id');
         return $this->morphTo('patient', 'patient_type', 'patient_id');
    }
    return $this->belongsTo(PregnantWoman::class, 'patient_id');
            return $this->morphTo(null, 'patient_type', 'patient_id');

}

    public function metrics()
    {
        return $this->hasOne(CheckupMetric::class);
    }


    protected static function booted()
    {
        static::created(function ($appointment) {
            if ($appointment->patient_type === 'App\Models\Baby' && $appointment->status === 'scheduled') {
                // Find the user associated with the baby
                $baby = Baby::find($appointment->patient_id);
                if ($baby && $baby->user) {
                    $message = "New {$appointment->type} appointment scheduled for " .
                               \Carbon\Carbon::parse($appointment->date)->format('F d, Y') .
                               ($appointment->time ? ' at ' . \Carbon\Carbon::parse($appointment->time)->format('h:i A') : '') .
                               ($appointment->type === 'vaccination' && $appointment->vaccination_type ? " ({$appointment->vaccination_type})" : '');

                    Notification::create([
                        'user_id' => $baby->user->id,
                        'appointment_id' => $appointment->id,
                        'message' => $message,
                        'read' => false,
                    ]);
                }
            }
        });
    }


    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }


    /**
     * Get the clinic record associated with the appointment.
     */
    public function clinicRecord()
    {
        return $this->hasOne(ClinicRecord::class, 'appointment_id', 'id');
    }

public function baby()
    {
        return $this->belongsTo(Baby::class, 'patient_id');
    }

}
