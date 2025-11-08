<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Filtros
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('shippingAddress', function($q) use ($search) {
                      $q->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->recent()->paginate(20);

        // Estadísticas
        $stats = [
            'total' => Order::count(),
            'pending' => Order::pending()->count(),
            'paid' => Order::paid()->count(),
            'processing' => Order::processing()->count(),
            'shipped' => Order::shipped()->count(),
            'delivered' => Order::delivered()->count(),
            'cancelled' => Order::cancelled()->count(),
            'total_revenue' => Order::paid()->sum('total'),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'shippingAddress', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled,refunded',
        ]);

        try {
            $this->orderService->updateStatus($order, $request->status);

            return redirect()
                ->back()
                ->with('success', 'Estado de la orden actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        try {
            $this->orderService->cancelOrder($order);

            return redirect()
                ->back()
                ->with('success', 'Orden cancelada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al cancelar la orden: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        $query = Order::with(['user', 'items', 'shippingAddress']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->recent()->get();

        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');

            // Encabezados
            fputcsv($file, [
                'Orden', 'Cliente', 'Email', 'Total', 'Estado',
                'Fecha', 'Pagado', 'Enviado', 'Entregado'
            ]);

            // Datos
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user?->name ?? $order->shippingAddress?->full_name ?? 'N/A',
                    $order->user?->email ?? $order->shippingAddress?->email ?? 'N/A',
                    '$' . number_format($order->total, 0, ',', '.'),
                    $order->getStatusText(),
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->paid_at ? 'Sí' : 'No',
                    $order->shipped_at ? 'Sí' : 'No',
                    $order->delivered_at ? 'Sí' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
