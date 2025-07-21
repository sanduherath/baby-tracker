<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Moh extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'registration_no',
        'nic',
        'date_of_birth',
        'contact',
        'moh_area',
        'hospital',
        'email',
        'midwives_supervised',
        'phm_areas_covered',
        'password',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    protected $hidden = [
        'password', // Hide password in API responses
    ];

    /**
     * The attributes that should be set with default values.
     *
     * @var array
     */
    protected $attributes = [
        'password' => null, // Set to null initially to check if provided
    ];

    /**
     * Automatically hash the password when setting it, using default 'moh123' if not provided.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value ?: 'moh123');
    }
}
