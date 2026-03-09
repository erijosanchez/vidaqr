<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'plan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }

    // ─── Helpers ───────────────────────────────────────────

    public function isPremium(): bool
    {
        return $this->plan === 'premium';
    }

    // ─── Relaciones ────────────────────────────────────────

    public function medicalProfile()
    {
        return $this->hasOne(MedicalProfile::class);
    }

    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function primaryContact()
    {
        return $this->hasOne(EmergencyContact::class)->where('is_primary', true);
    }

    public function qrToken()
    {
        return $this->hasOne(QrToken::class);
    }

    public function sosAlerts()
    {
        return $this->hasMany(SosAlert::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class)->latest();
    }
}
