<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Available user roles for the maternal/baby tracking system
     */
    public const ROLES = [
        'parent' => 'Parent',
        'baby' => 'Baby',
        'pregnant' => 'Pregnant Woman',
        'midwife' => 'Midwife',
        'moh' => 'Ministry of Health (MOH)',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'date_of_birth',
        'expected_due_date',
        'license_number',
        'health_facility',
        'address',
        'patientable_id',
        'patientable_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'expected_due_date' => 'date',
        ];
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    // Role-specific methods
    public function isBaby(): bool
    {
        return $this->hasRole('baby');
    }

    public function isPregnantWoman(): bool
    {
        return $this->hasRole('pregnant'); // Updated to match ROLES constant
    }

    public function isMidwife(): bool
    {
        return $this->hasRole('midwife');
    }

    public function isMoh(): bool
    {
        return $this->hasRole('moh');
    }

    /**
     * Relationship: Babies belong to pregnant women
     */
    public function mother()
    {
        return $this->belongsTo(User::class, 'mother_id')->where('role', 'pregnant');
    }

    /**
     * Relationship: Pregnant women have babies
     */
    public function babies()
    {
        return $this->hasMany(User::class, 'mother_id')->where('role', 'baby');
    }

    /**
     * Relationship: Midwives assigned to pregnant women
     */
    public function assignedPregnancies()
    {
        return $this->belongsToMany(User::class, 'midwife_pregnancies', 'midwife_id', 'pregnant_id')
            ->where('role', 'pregnant');
    }

    /**
     * Relationship: MOH can view all records
     */
    public function allRecords()
    {
        if ($this->isMoh()) {
            return User::whereIn('role', ['baby', 'pregnant']);
        }
        return null;
    }

    /**
     * Get display name based on role
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->isBaby()
            ? "Baby {$this->name}"
            : $this->name;
    }

    /**
     * Polymorphic relationship to patientable
     */
    public function patientable()
    {
        return $this->morphTo();
    }

    /**
     * Get the patient record
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Relationship: User has one Midwife
     */
    public function midwife()
    {
        return $this->hasOne(Midwife::class, 'email', 'email');
    }
   public function baby()
    {
        return $this->hasOne(Baby::class);
    }


}
