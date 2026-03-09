<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'shared_until',
        'share_token',
    ];

    protected $casts = [
        'shared_until' => 'datetime',
    ];

    // ─── Relaciones ────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ───────────────────────────────────────────

    public function isSharedActive(): bool
    {
        return $this->shared_until && $this->shared_until->isFuture();
    }

    public function getShareLinkAttribute(): ?string
    {
        return $this->share_token
            ? route('location.share', $this->share_token)
            : null;
    }

    public function generateShareToken(int $hours = 24): void
    {
        $this->update([
            'share_token'  => Str::uuid(),
            'shared_until' => now()->addHours($hours),
        ]);
    }

    public function getMapsLinkAttribute(): string
    {
        return "https://maps.google.com/?q={$this->latitude},{$this->longitude}";
    }
}
