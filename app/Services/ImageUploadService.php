<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Configuración de tamaños máximos por tipo de carpeta
     */
    protected array $config = [
        'services' => ['max_width' => 800, 'max_height' => 600],
        'projects' => ['max_width' => 1200, 'max_height' => 800],
        'testimonials' => ['max_width' => 400, 'max_height' => 400],
        'gallery' => ['max_width' => 1920, 'max_height' => 1080],
        'hero' => ['max_width' => 1920, 'max_height' => 1080],
        'settings' => ['max_width' => 500, 'max_height' => 500],
    ];

    /**
     * Subir y optimizar imagen simple
     */
    public function upload(UploadedFile $file, string $directory): string
    {
        $this->validateFile($file);
        $this->ensureDirectoryExists($directory);

        $filename = $this->generateFilename($file);
        $path = public_path("images/{$directory}");

        try {
            $file->move($path, $filename);
            Log::info("✅ Imagen subida: images/{$directory}/{$filename}");
            return "{$directory}/{$filename}";
        } catch (\Exception $e) {
            Log::error("❌ Error al subir imagen: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Subir imagen con redimensionamiento
     * (usa Intervention Image si está instalado)
     */
    public function uploadWithResize(UploadedFile $file, string $folder = 'projects'): string
    {
        $this->validateFile($file);
        $config = $this->getConfig($folder) ?? ['max_width' => 1200, 'max_height' => 1200];

        $filename = $this->generateFilename($file);
        $path = public_path("images/{$folder}");
        $this->ensureDirectoryExists($folder);

        // Si Intervention Image está disponible
        if (class_exists('\Intervention\Image\Facades\Image')) {
            try {
                $image = \Intervention\Image\Facades\Image::make($file);
                $image->resize($config['max_width'], $config['max_height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($path . '/' . $filename, 85);
                Log::info("🖼️ Imagen redimensionada correctamente: {$folder}/{$filename}");
            } catch (\Exception $e) {
                Log::warning("⚠️ Error al redimensionar, se guarda original: " . $e->getMessage());
                $file->move($path, $filename);
            }
        } else {
            // Si no está instalado Intervention, subir sin redimensionar
            $file->move($path, $filename);
        }

        return "{$folder}/{$filename}";
    }

    /**
     * Subir video
     */
    public function uploadVideo(UploadedFile $file, string $directory): string
    {
        $this->ensureDirectoryExists($directory, 'videos');
        $filename = $this->generateFilename($file);
        $path = public_path("videos/{$directory}");

        try {
            $file->move($path, $filename);
            Log::info("🎬 Video subido: videos/{$directory}/{$filename}");
            return "{$directory}/{$filename}";
        } catch (\Exception $e) {
            Log::error("❌ Error al subir video: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Eliminar archivo (imagen o video)
     */
    public function delete(?string $relativePath, string $type = 'images'): bool
    {
        if (!$relativePath) {
            return false;
        }

        $possiblePaths = [
            public_path("{$type}/{$relativePath}"),
            public_path("images/{$relativePath}"),
            public_path("videos/{$relativePath}"),
            public_path($relativePath),
        ];

        foreach ($possiblePaths as $fullPath) {
            if (File::exists($fullPath)) {
                try {
                    File::delete($fullPath);
                    Log::info("🗑️ Archivo eliminado: {$fullPath}");
                    return true;
                } catch (\Exception $e) {
                    Log::error("❌ Error al eliminar archivo: " . $e->getMessage());
                }
            }
        }

        return false;
    }

    /**
     * Subir múltiples imágenes
     */
    public function uploadMultiple(array $files, string $folder = 'images'): array
    {
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $uploadedFiles[] = $this->upload($file, $folder);
            }
        }

        return $uploadedFiles;
    }

    /**
     * Asegura que el directorio exista (images o videos)
     */
    protected function ensureDirectoryExists(string $directory, string $type = 'images'): void
    {
        $directory = trim($directory, '/');
        $path = public_path("{$type}/{$directory}");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            Log::info("📁 Directorio creado: {$path}");
        }
    }

    /**
     * Genera nombre único para archivo
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return time() . '_' . Str::random(10) . '.' . strtolower($extension);
    }

    /**
     * Obtiene configuración para un directorio (ancho/alto)
     */
    public function getConfig(string $directory): ?array
    {
        return $this->config[$directory] ?? null;
    }

    /**
     * Valida tipo y tamaño del archivo antes de subir
     */
    protected function validateFile(UploadedFile $file): void
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4', 'mov', 'avi'];
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, $allowed)) {
            throw new \Exception("Tipo de archivo no permitido: {$ext}");
        }

        // Máximo 5 MB
        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new \Exception('El archivo excede el tamaño máximo permitido (5 MB).');
        }
    }
}
