<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalProfile extends Model
{
    protected $fillable = [
        'user_id',
        'photo',
        'blood_type',
        'allergies',
        'diseases',
        'medications',
        'observations',
    ];

    // ─── Relaciones ────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ───────────────────────────────────────────

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-avatar.png');
    }
}
