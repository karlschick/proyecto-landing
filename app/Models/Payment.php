<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'method',
        'reference',
        'amount',
        'currency',
        'status',
        'payment_gateway',
        'receipt_path',
        'metadata',
        'paid_at',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'metadata' => 'array',
    ];

    // Relaciones
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePendingVerification($query)
    {
        return $query->where('status', 'pending_verification');
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('status', ['completed', 'approved']);
    }

    // Helpers
    public function getReceiptUrl(): ?string
    {
        if (!$this->receipt_path) {
            return null;
        }

        return asset('storage/' . $this->receipt_path);
    }

    public function getStatusText(): string
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'pending_verification' => 'En Revisión',
            'completed', 'approved' => 'Aprobado',
            'failed', 'rejected' => 'Rechazado',
            'cancelled' => 'Cancelado',
            default => 'Desconocido',
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'completed', 'approved' => 'bg-green-100 text-green-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'pending_verification' => 'bg-blue-100 text-blue-800',
            'failed', 'rejected' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    public function getMethodName(): string
    {
        return match($this->method) {
            'manual_breb' => 'Bre-b (Llave)',
            'manual_transfer' => 'Transferencia Bancaria',
            'manual_qr' => 'Código QR',
            'card' => 'Tarjeta de Crédito/Débito',
            'cash_on_delivery' => 'Contra Entrega',
            default => 'Método Desconocido',
        };
    }
}
