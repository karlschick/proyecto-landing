<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Listar todos los leads
     */
    public function index(Request $request)
    {
        $query = Lead::query();

        // Filtro por estado
        if ($request->has('status') && $request->status != '') {
            $query->byStatus($request->status);
        }

        // Filtro por leído/no leído
        if ($request->has('read') && $request->read != '') {
            if ($request->read == 'unread') {
                $query->unread();
            } elseif ($request->read == 'read') {
                $query->read();
            }
        }

        // Búsqueda
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $leads = $query->recent()->paginate(20);

        // Estadísticas
        $stats = [
            'total' => Lead::count(),
            'nuevos' => Lead::byStatus('nuevo')->count(),
            'no_leidos' => Lead::unread()->count(),
            'contactados' => Lead::byStatus('contactado')->count(),
            'convertidos' => Lead::byStatus('convertido')->count(),
        ];

        return view('admin.leads.index', compact('leads', 'stats'));
    }

    /**
     * Ver detalle de un lead
     */
    public function show(Lead $lead)
    {
        // Marcar como leído automáticamente
        $lead->markAsRead();

        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Actualizar estado de un lead
     */
    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate([
            'status' => 'required|in:nuevo,contactado,calificado,convertido,descartado',
        ]);

        $lead->update(['status' => $request->status]);

        if ($request->status === 'contactado') {
            $lead->markAsContacted();
        }

        return redirect()
            ->back()
            ->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Actualizar notas del admin
     */
    public function updateNotes(Request $request, Lead $lead)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $lead->update(['admin_notes' => $request->admin_notes]);

        return redirect()
            ->back()
            ->with('success', 'Notas actualizadas correctamente.');
    }

    /**
     * Eliminar un lead
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()
            ->route('admin.leads.index')
            ->with('success', 'Lead eliminado correctamente.');
    }

    /**
     * Marcar múltiples leads como leídos
     */
    public function markAsReadBulk(Request $request)
    {
        $request->validate([
            'lead_ids' => 'required|array',
            'lead_ids.*' => 'exists:leads,id',
        ]);

        Lead::whereIn('id', $request->lead_ids)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Leads marcados como leídos.');
    }

    /**
     * Exportar leads a CSV
     */
    public function export(Request $request)
    {
        $query = Lead::query();

        if ($request->has('status') && $request->status != '') {
            $query->byStatus($request->status);
        }

        $leads = $query->recent()->get();

        $filename = 'leads_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($leads) {
            $file = fopen('php://output', 'w');

            // Encabezados
            fputcsv($file, [
                'ID', 'Nombre', 'Email', 'Teléfono', 'Asunto',
                'Mensaje', 'Estado', 'Fecha', 'Leído', 'Contactado'
            ]);

            // Datos
            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->name,
                    $lead->email,
                    $lead->phone,
                    $lead->subject,
                    $lead->message,
                    $lead->getStatusText(),
                    $lead->created_at->format('Y-m-d H:i:s'),
                    $lead->read_at ? 'Sí' : 'No',
                    $lead->contacted_at ? 'Sí' : 'No',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
