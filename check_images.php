<?php

use App\Models\Product;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$product = Product::with('images')->first();

echo "Producto: " . $product->name . "\n";

echo "\nImágenes:\n";
foreach ($product->images as $image) {
    $path = storage_path('app/public/' . $image->image_path);
    $exists = file_exists($path) ? 'Sí' : 'No';
    echo "- Ruta: " . $image->image_path . "\n";
    echo "  URL: " . $image->image_url . "\n";
    echo "  Existe: " . $exists . "\n";
    echo "  Ruta completa: " . $path . "\n\n";
}
