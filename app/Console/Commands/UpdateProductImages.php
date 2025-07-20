<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateProductImages extends Command
{
    protected $signature = 'products:update-images';
    protected $description = 'Actualiza todas las rutas de imágenes de productos para que apunten a una imagen existente';

    public function handle()
    {
        $existingImage = 'images/products/SISFSWA6UAFg7hhxNhoMnD9Qu7brxYGLwFk4oDcy.jpg';
        
        // Verificar si la imagen existe
        if (!file_exists(storage_path('app/public/' . $existingImage))) {
            $this->error("La imagen de referencia no existe en la ruta: " . storage_path('app/public/' . $existingImage));
            return 1;
        }
        
        $this->info("Actualizando todas las imágenes de productos a: " . $existingImage);
        
        // Actualizar todas las imágenes de productos
        $updated = DB::table('product_images')
            ->update(['image_path' => $existingImage]);
            
        $this->info("¡Actualización completada! Se actualizaron $updated registros.");
        $this->info("URL de la imagen: " . asset('storage/' . $existingImage));
        
        return 0;
    }
}
