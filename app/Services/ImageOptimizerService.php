<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Optimiza y redimensiona una imagen, generando versiones en diferentes tamaños.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @param  string  $path
     * @param  array  $sizes
     * @return string
     */
    public function optimizeAndResize($image, $path, $sizes = [])
    {
        $optimizerChain = OptimizerChainFactory::create();
        $fileName = Str::uuid() . '.webp';
        $storagePath = 'public/' . trim($path, '/');
        
        // Crear directorio si no existe
        if (!Storage::exists($storagePath)) {
            Storage::makeDirectory($storagePath);
        }
        
        $fullPath = storage_path('app/' . $storagePath . '/' . $fileName);
        
        // Cargar la imagen con Intervention
        $img = Image::make($image);
        
        // Si se especifican tamaños, crear versiones
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                $this->createSizeVariant($img, $size, $storagePath, $fileName);
            }
        }
        
        // Guardar versión original optimizada en WebP
        $img->encode('webp', 80)->save($fullPath);
        
        // Optimizar la imagen resultante
        $optimizerChain->optimize($fullPath);
        
        return $path . '/' . $fileName;
    }
    
    /**
     * Crea una variante de tamaño de la imagen.
     *
     * @param  \Intervention\Image\Image  $img
     * @param  array  $size
     * @param  string  $path
     * @param  string  $originalName
     * @return void
     */
    protected function createSizeVariant($img, $size, $path, $originalName)
    {
        $variantPath = storage_path("app/{$path}/{$size['name']}");
        
        if (!file_exists($variantPath)) {
            mkdir($variantPath, 0755, true);
        }
        
        $img->resize($size['width'], $size['height'], function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('webp', 80)
          ->save("{$variantPath}/{$originalName}");
          
        // Optimizar la miniatura
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize("{$variantPath}/{$originalName}");
    }
}
