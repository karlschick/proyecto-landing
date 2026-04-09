<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Helpers de rol ──────────────────────────────────────
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isEditor(): bool     { return $this->role === 'editor'; }
    public function isResearcher(): bool { return $this->role === 'researcher'; }
    public function isColumnist(): bool  { return $this->role === 'columnist'; }
    public function isSeller(): bool     { return $this->role === 'seller'; }
    public function isCustomer(): bool   { return $this->role === 'customer'; }
    public function isUser(): bool       { return $this->role === 'user'; }

    // ── Helpers de permisos combinados ──────────────────────
    public function canEdit(): bool
    {
        return in_array($this->role, ['admin', 'editor']);
    }

    public function canPublishContent(): bool
    {
        return in_array($this->role, ['admin', 'editor', 'researcher', 'columnist']);
    }

    public function canSell(): bool
    {
        return in_array($this->role, ['admin', 'seller']);
    }
}
