<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Midwife extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'nic',
        'contact_number',
        'email',
        'phm_area',
        'registration_number',
        'start_date',
        'training_level',
        'address',
        'notes',
        'active_status',
        'password', // Added password field
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', // Hide password in API responses
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'active_status' => 'boolean',
            'password' => 'hashed', // Ensure password is hashed
        ];
    }

    /**
     * Relationship: Midwife belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function babies()
    {
        return $this->hasMany(Baby::class);
    }

    public function pregnantWomen()
    {
        return $this->hasMany(PregnantWoman::class);
    }
}
