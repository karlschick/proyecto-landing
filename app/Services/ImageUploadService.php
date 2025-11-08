<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageUploadService
{
    protected array $config = [
        'services' => ['max_width' => 800, 'max_height' => 600],
        'projects' => ['max_width' => 1200, 'max_height' => 800],
        'testimonials' => ['max_width' => 400, 'max_height' => 400],
        'gallery' => ['max_width' => 1920, 'max_height' => 1080],
        'hero' => ['max_width' => 1920, 'max_height' => 1080],
        'settings' => ['max_width' => 500, 'max_height' => 500],
    ];

    /**
     * Subir y optimizar imagen
     */
    public function upload(UploadedFile $file, string $directory): string
    {
        $this->ensureDirectoryExists($directory);

        $filename = $this->generateFilename($file);
        $path = public_path("images/{$directory}");

        try {
            $file->move($path, $filename);

            Log::info("Image uploaded successfully: {$directory}/{$filename}");

            return $filename;
        } catch (\Exception $e) {
            Log::error("Error uploading image: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Subir imagen con redimensionamiento
     */
    public function uploadWithResize(
        UploadedFile $file,
        string $folder = 'images',
        int $maxWidth = 1200,
        int $maxHeight = 1200
    ): string {
        $filename = $this->generateFilename($file);
        $path = public_path("images/{$folder}");

        $this->ensureDirectoryExists($folder);

        // Si tienes Intervention Image instalado, usa este bloque
        // Descomentar si tienes el paquete: composer require intervention/image
        /*
        try {
            $image = \Intervention\Image\Facades\Image::make($file);

            $image->resize($maxWidth, $maxHeight, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $image->save($path . '/' . $filename, 85);
        } catch (\Exception $e) {
            $file->move($path, $filename);
        }
        */

        // Sin Intervention Image, usa el método simple
        $file->move($path, $filename);

        return $filename;
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

            Log::info("Video uploaded successfully: {$directory}/{$filename}");

            return $filename;
        } catch (\Exception $e) {
            Log::error("Error uploading video: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Eliminar archivo
     */
    public function delete(?string $path, string $type = 'images'): bool
    {
        if (!$path) {
            return false;
        }

        $possiblePaths = [
            public_path("{$type}/" . $path),
            public_path($path),
        ];

        foreach ($possiblePaths as $fullPath) {
            if (File::exists($fullPath)) {
                try {
                    File::delete($fullPath);
                    Log::info("File deleted successfully: {$fullPath}");
                    return true;
                } catch (\Exception $e) {
                    Log::error("Error deleting file: " . $e->getMessage());
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
     * Asegurar que el directorio existe
     */
    protected function ensureDirectoryExists(string $directory, string $type = 'images'): void
    {
        $path = public_path("{$type}/{$directory}");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    /**
     * Generar nombre único para archivo
     */
    protected function generateFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        return time() . '_' . Str::random(10) . '.' . $extension;
    }

    /**
     * Obtener configuración para un directorio
     */
    public function getConfig(string $directory): ?array
    {
        return $this->config[$directory] ?? null;
    }
}
