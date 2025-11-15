<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'user_email',
        'download_token',
        'downloads_count',
        'max_downloads',
        'expires_at',
        'last_downloaded_at',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_downloaded_at' => 'datetime',
    ];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Generar token único
    public static function generateToken(): string
    {
        do {
            $token = Str::random(64);
        } while (self::where('download_token', $token)->exists());

        return $token;
    }

    // Verificar si puede descargar
    public function canDownload(): bool
    {
        // Verificar si no ha expirado
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Verificar límite de descargas
        if ($this->downloads_count >= $this->max_downloads) {
            return false;
        }

        return true;
    }

    // Incrementar contador de descargas
    public function incrementDownload(string $ipAddress = null): void
    {
        $this->increment('downloads_count');
        $this->update([
            'last_downloaded_at' => now(),
            'ip_address' => $ipAddress,
        ]);
    }

    // Obtener días restantes
    public function getRemainingDays(): ?int
    {
        if (!$this->expires_at) {
            return null;
        }

        return max(0, now()->diffInDays($this->expires_at, false));
    }

    // Obtener descargas restantes
    public function getRemainingDownloads(): int
    {
        return max(0, $this->max_downloads - $this->downloads_count);
    }

    // Scope para tokens válidos
    public function scopeValid($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        })->whereRaw('downloads_count < max_downloads');
    }
}
