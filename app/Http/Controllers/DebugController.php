<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebugController extends Controller
{
    public function checkImages()
    {
        // Obtener las primeras 5 imágenes de productos
        $images = ProductImage::take(5)->get(['id', 'image_path']);
        
        // Verificar la estructura de la tabla
        $columns = \Schema::getColumnListing('product_images');
        
        // Verificar si las imágenes existen físicamente
        $imagesWithStatus = [];
        foreach ($images as $image) {
            $path = storage_path('app/public/' . $image->image_path);
            $imagesWithStatus[] = [
                'id' => $image->id,
                'path' => $image->image_path,
                'exists' => file_exists($path),
                'full_path' => $path,
                'url' => asset('storage/' . $image->image_path)
            ];
        }
        
        return response()->json([
            'columns' => $columns,
            'images' => $imagesWithStatus,
            'storage_path' => storage_path('app/public'),
            'public_path' => public_path('storage'),
            'is_link' => is_link(public_path('storage')),
            'link_target' => is_link(public_path('storage')) ? readlink(public_path('storage')) : null,
            'app_url' => config('app.url'),
            'filesystem_public_url' => config('filesystems.disks.public.url')
        ]);
    }
}
