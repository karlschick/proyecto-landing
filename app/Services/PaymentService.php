<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    // Configuración de métodos de pago
    protected array $paymentMethods = [
        'manual_breb' => [
            'name' => 'Bre-b (Llave)',
            'key' => '0091257502',
            'phone' => '3115765959',
            'comercio' => 'SKUBOXIT',
        ],
        'manual_transfer' => [
            'name' => 'Transferencia Bancaria',
            'bank' => 'Bancolombia',
            'account_type' => 'Ahorros',
            'account_number' => '12345678901',
            'holder' => 'SkuboxIT SAS',
            'nit' => '900123456-7',
        ],
        'manual_qr' => [
            'name' => 'Código QR',
            'qr_image' => '/images/qr/qrbreb.jpg',
            'instructions' => 'Escanea el código QR con tu app bancaria',
        ],
        'card' => [
            'name' => 'Tarjeta Débito/Crédito',
            'gateway' => 'pending', // Aquí iría PayU, Mercadopago, etc
        ],
        'cash_on_delivery' => [
            'name' => 'Pago Contra Entrega',
            'description' => 'Paga en efectivo al recibir tu pedido',
        ],
    ];

    /**
     * Procesar pago (dispatcher general)
     */
    public function processPayment(Order $order, string $method, array $payload = []): Payment
    {
        // Validar que el método sea soportado
        if (!isset($this->paymentMethods[$method])) {
            throw new \Exception("Método de pago no soportado: {$method}");
        }

        return $this->createPayment($order, $method);
    }

    /**
     * Crear un pago
     */
    public function createPayment(Order $order, string $method): Payment
    {
        return DB::transaction(function () use ($order, $method) {
            $reference = $this->generateReference($method);

            // Determinar estado inicial
            $status = ($method === 'cash_on_delivery') ? 'pending' : 'pending';

            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => $method,
                'reference' => $reference,
                'amount' => $order->total,
                'currency' => 'COP',
                'status' => $status,
                'payment_gateway' => $this->paymentMethods[$method]['name'] ?? null,
                'metadata' => json_encode($this->paymentMethods[$method] ?? []),
            ]);

            // Actualizar estado de orden según método
            if ($method === 'cash_on_delivery') {
                $order->update(['status' => 'processing']); // Contra entrega va directo a procesamiento
            } else {
                $order->update(['status' => 'pending']); // Otros métodos esperan pago
            }

            Log::info('Pago creado', [
                'payment_id' => $payment->id,
                'order_id' => $order->id,
                'method' => $method,
                'reference' => $reference,
                'amount' => $order->total
            ]);

            return $payment;
        });
    }

    /**
     * Generar referencia única
     */
    protected function generateReference(string $method): string
    {
        $prefix = match($method) {
            'manual_breb' => 'BREB',
            'manual_transfer' => 'TRANS',
            'manual_qr' => 'QR',
            'card' => 'CARD',
            'cash_on_delivery' => 'COD',
            default => 'PAY',
        };

        return $prefix . '-' . strtoupper(uniqid());
    }

    /**
     * Subir comprobante de pago - MEJORADO
     */
    public function uploadReceipt(Payment $payment, $file): bool
    {
        try {
            // Log inicial
            Log::info('📤 Iniciando subida de comprobante', [
                'payment_id' => $payment->id,
                'order_number' => $payment->order->order_number,
                'file_original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'file_extension' => $file->getClientOriginalExtension()
            ]);

            // Eliminar comprobante anterior si existe
            if ($payment->receipt_path && Storage::disk('public')->exists($payment->receipt_path)) {
                Storage::disk('public')->delete($payment->receipt_path);
                Log::info('🗑️ Comprobante anterior eliminado', ['path' => $payment->receipt_path]);
            }

            // Generar nombre único para el archivo
            $filename = 'receipt_' . $payment->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Guardar en storage/app/public/receipts
            $path = $file->storeAs('receipts', $filename, 'public');

            // Log detallado
            Log::info('💾 Archivo guardado', [
                'payment_id' => $payment->id,
                'path' => $path,
                'full_path' => storage_path('app/public/' . $path),
                'public_url' => Storage::disk('public')->url($path)
            ]);

            // Actualizar el registro en la base de datos
            $payment->update([
                'receipt_path' => $path,
                'status' => 'pending_verification' // Cambiar estado cuando suben comprobante
            ]);

            // Verificar que se guardó correctamente
            if (Storage::disk('public')->exists($path)) {
                Log::info('✅ Comprobante verificado exitosamente', [
                    'payment_id' => $payment->id,
                    'file_exists' => true,
                    'path' => $path
                ]);
                return true;
            } else {
                Log::error('❌ El archivo no existe después de guardarlo', [
                    'payment_id' => $payment->id,
                    'expected_path' => $path
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('❌ Error al subir comprobante', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Actualizar comprobante (alias para compatibilidad)
     */
    public function updateReceipt(Payment $payment, string $receiptPath): void
    {
        $payment->update([
            'receipt_path' => $receiptPath,
            'status' => 'pending_verification'
        ]);

        Log::info('Comprobante de pago actualizado', [
            'payment_id' => $payment->id,
            'receipt' => $receiptPath
        ]);
    }

    /**
     * Aprobar pago
     */
    public function approvePayment(Payment $payment, ?int $adminId, ?string $notes = null, ?string $deliveryLink = null): void
    {
        DB::transaction(function () use ($payment, $adminId, $notes, $deliveryLink) {
            $payment->update([
                'status' => 'completed',
                'admin_notes' => $notes,
                'reviewed_by' => $adminId,
                'reviewed_at' => now(),
                'paid_at' => now(),
            ]);

            $updateData = [
                'status' => 'paid',
                'paid_at' => now(),
            ];

            if ($deliveryLink) {
                $updateData['delivery_link'] = $deliveryLink;
            }

            $payment->order->update($updateData);

            Log::info('✅ Pago aprobado', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order->id,
                'admin_id' => $adminId,
                'delivery_link' => $deliveryLink
            ]);

            // TODO: Enviar email con el link de entrega
        });
    }

    /**
     * Verificar pago (alias para approvePayment)
     */
    public function verifyPayment(Payment $payment, string $verifiedBy): void
    {
        $this->approvePayment($payment, (int)$verifiedBy);
    }

    /**
     * Rechazar pago
     */
    public function rejectPayment(Payment $payment, ?int $adminId, string $reason, ?string $rejectedBy = null): void
    {
        DB::transaction(function () use ($payment, $adminId, $reason, $rejectedBy) {
            $payment->update([
                'status' => 'failed',
                'admin_notes' => $reason,
                'reviewed_by' => $adminId,
                'reviewed_at' => now(),
                'metadata' => json_encode(array_merge(
                    json_decode($payment->metadata ?? '{}', true),
                    [
                        'rejected_by' => $rejectedBy ?? $adminId,
                        'rejected_at' => now(),
                        'rejection_reason' => $reason
                    ]
                ))
            ]);

            $payment->order->update(['status' => 'payment_failed']);

            Log::info('❌ Pago rechazado', [
                'payment_id' => $payment->id,
                'order_id' => $payment->order->id,
                'admin_id' => $adminId,
                'reason' => $reason
            ]);
        });
    }

    /**
     * Obtener información del método de pago
     */
    public function getPaymentInfo(string $method): array
    {
        return $this->paymentMethods[$method] ?? [];
    }

    /**
     * Obtener nombre del método de pago
     */
    public function getPaymentMethodName(string $method): string
    {
        return $this->paymentMethods[$method]['name'] ?? 'Método desconocido';
    }

    /**
     * Obtener métodos de pago disponibles
     */
    public function getAvailablePaymentMethods(bool $isDigitalOnly = false): array
    {
        $methods = [
            'manual_transfer' => [
                'name' => 'Transferencia Bancaria',
                'icon' => '🏦',
                'description' => 'Pago por transferencia',
                'available_for' => ['digital', 'physical']
            ],
            'card' => [
                'name' => 'Tarjeta Débito/Crédito',
                'icon' => '💳',
                'description' => 'Pago con tarjeta',
                'available_for' => ['digital', 'physical']
            ],
        ];

        if ($isDigitalOnly) {
            // Métodos solo para productos digitales
            $methods['manual_breb'] = [
                'name' => 'Bre-b (Llave)',
                'icon' => '🔑',
                'description' => 'Pago manual con llave Bre-b',
                'available_for' => ['digital']
            ];
            $methods['manual_qr'] = [
                'name' => 'Código QR',
                'icon' => '📱',
                'description' => 'Escanea y paga',
                'available_for' => ['digital']
            ];
        } else {
            // Método solo para productos físicos
            $methods['cash_on_delivery'] = [
                'name' => 'Pago Contra Entrega',
                'icon' => '💵',
                'description' => 'Paga en efectivo al recibir',
                'available_for' => ['physical']
            ];
        }

        return $methods;
    }
}
