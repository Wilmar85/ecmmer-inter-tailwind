<?php

use App\Models\ProductImage;
use Illuminate\Support\Facades\File;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$images = ProductImage::all();

echo "Iniciando verificación de imágenes...\n";

foreach ($images as $image) {
    $oldPath = storage_path('app/public/' . $image->image_path);
    $newPath = storage_path('app/public/images/products/' . basename($image->image_path));
    
    // Si la imagen está en la ubicación antigua, la movemos a la nueva
    if (file_exists($oldPath) && !file_exists($newPath)) {
        echo "Moviendo: " . $image->image_path . " a images/products/" . basename($image->image_path) . "\n";
        File::move($oldPath, $newPath);
    } elseif (file_exists($newPath)) {
        echo "La imagen ya existe en la nueva ubicación: " . $newPath . "\n";
    } else {
        echo "No se encontró la imagen: " . $oldPath . "\n";
    }
    
    // Actualizar la ruta en la base de datos
    $image->update([
        'image_path' => 'images/products/' . basename($image->image_path)
    ]);
}

echo "Proceso completado.\n";
