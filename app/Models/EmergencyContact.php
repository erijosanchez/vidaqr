<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'relationship',
        'phone',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // ─── Relaciones ────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ───────────────────────────────────────────

    public function getWhatsappLinkAttribute(): string
    {
        $phone = preg_replace('/\D/', '', $this->phone);
        return "https://wa.me/51{$phone}";
    }

    public function getCallLinkAttribute(): string
    {
        return "tel:{$this->phone}";
    }
}
