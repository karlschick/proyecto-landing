<?php

namespace App\Http\Controllers;

use App\Models\ProductDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Mostrar página de descarga con información
     */
    public function show(string $token)
    {
        $download = ProductDownload::with(['product', 'order'])
            ->where('download_token', $token)
            ->firstOrFail();

        // Verificar si puede descargar
        if (!$download->canDownload()) {
            return view('landing.downloads.expired', compact('download'));
        }

        return view('landing.downloads.show', compact('download'));
    }

    /**
     * Descargar archivo
     */
    public function download(string $token, Request $request)
    {
        $download = ProductDownload::with('product')
            ->where('download_token', $token)
            ->firstOrFail();

        // Verificar si puede descargar
        if (!$download->canDownload()) {
            if ($download->expires_at && $download->expires_at->isPast()) {
                return redirect()
                    ->route('downloads.show', $token)
                    ->with('error', 'Este link de descarga ha expirado.');
            }

            return redirect()
                ->route('downloads.show', $token)
                ->with('error', 'Has alcanzado el límite de descargas para este producto.');
        }

        $product = $download->product;

        // Verificar que el archivo existe
        if (!$product->hasFile()) {
            return redirect()
                ->route('downloads.show', $token)
                ->with('error', 'El archivo no está disponible. Contacta a soporte.');
        }

        // Incrementar contador de descargas
        $download->incrementDownload($request->ip());

        // Log de descarga
        \Log::info('Descarga de producto', [
            'download_id' => $download->id,
            'product_id' => $product->id,
            'order_id' => $download->order_id,
            'ip' => $request->ip(),
            'remaining' => $download->getRemainingDownloads()
        ]);

        // Descargar archivo
        return Storage::download(
            $product->file_path,
            $product->slug . '.pdf',
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $product->slug . '.pdf"'
            ]
        );
    }
}
