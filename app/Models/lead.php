<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lead extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'status',
        'admin_notes',
        'read_at',
        'contacted_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'contacted_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Marcar como leído
     */
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Marcar como contactado
     */
    public function markAsContacted()
    {
        if (!$this->contacted_at) {
            $this->update([
                'contacted_at' => now(),
                'status' => 'contactado'
            ]);
        }
    }

    /**
     * Verificar si es nuevo
     */
    public function isNew(): bool
    {
        return $this->status === 'nuevo' && !$this->read_at;
    }

    /**
     * Obtener badge de estado
     */
    public function getStatusBadge(): string
    {
        return match($this->status) {
            'nuevo' => 'bg-blue-100 text-blue-800',
            'contactado' => 'bg-yellow-100 text-yellow-800',
            'calificado' => 'bg-purple-100 text-purple-800',
            'convertido' => 'bg-green-100 text-green-800',
            'descartado' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Obtener texto de estado
     */
    public function getStatusText(): string
    {
        return match($this->status) {
            'nuevo' => 'Nuevo',
            'contactado' => 'Contactado',
            'calificado' => 'Calificado',
            'convertido' => 'Convertido',
            'descartado' => 'Descartado',
            default => 'Desconocido',
        };
    }

    /**
     * Formatear fecha relativa
     */
    public function getTimeAgo(): string
    {
        return $this->created_at->diffForHumans();
    }
}
