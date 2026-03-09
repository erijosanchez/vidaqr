<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QrToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'qr_image_path',
        'is_active',
        'scans_count',
        'last_scanned_at',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'last_scanned_at' => 'datetime',
    ];

    // ─── Boot ──────────────────────────────────────────────

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($qr) {
            if (empty($qr->token)) {
                $qr->token = Str::uuid();
            }
        });
    }

    // ─── Relaciones ────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Helpers ───────────────────────────────────────────

    public function getPublicUrlAttribute(): string
    {
        return route('emergency.profile', $this->token);
    }

    public function getQrImageUrlAttribute(): string
    {
        return $this->qr_image_path
            ? asset($this->qr_image_path)
            : null;
    }

    public function registerScan(): void
    {
        $this->increment('scans_count');
        $this->update(['last_scanned_at' => now()]);
    }
}
