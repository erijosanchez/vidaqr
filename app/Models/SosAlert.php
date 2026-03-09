<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SosAlert extends Model
{
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'triggered_by',
        'status',
    ];

    // ─── Relaciones ────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ───────────────────────────────────────────

    public function getMapsLinkAttribute(): ?string
    {
        if ($this->latitude && $this->longitude) {
            return "https://maps.google.com/?q={$this->latitude},{$this->longitude}";
        }
        return null;
    }

    public function resolve(): void
    {
        $this->update(['status' => 'resolved']);
    }
}