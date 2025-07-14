<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $smartphones = Category::where('name', 'Smartphones')->first();
        $laptops = Category::where('name', 'Laptops')->first();
        $tablets = Category::where('name', 'Tablets')->first();

        // Smartphones
        $this->createProduct([
            'name' => 'Smartphone X Pro',
            'description' => 'Smartphone de última generación con cámara de 108MP y pantalla AMOLED',
            'price' => 899.99,
            'sku' => 'SP-X-PRO-001',
            'stock' => 50,
            'is_featured' => true,
            'category_id' => $smartphones->id,
            'images' => [
                'images/products/smartphone-x-pro-1.jpg',
                'images/products/smartphone-x-pro-2.jpg',
            ]
        ]);

        // Laptops
        $this->createProduct([
            'name' => 'Laptop Pro Book',
            'description' => 'Laptop profesional con procesador de última generación y 16GB RAM',
            'price' => 1299.99,
            'sku' => 'LP-PRO-001',
            'stock' => 30,
            'is_featured' => true,
            'category_id' => $laptops->id,
            'images' => [
                'images/products/laptop-pro-1.jpg',
                'images/products/laptop-pro-2.jpg',
            ]
        ]);

        // Tablets
        $this->createProduct([
            'name' => 'Tablet Ultra',
            'description' => 'Tablet con pantalla 2K y lápiz digital incluido',
            'price' => 499.99,
            'sku' => 'TB-ULTRA-001',
            'stock' => 40,
            'is_featured' => true,
            'category_id' => $tablets->id,
            'images' => [
                'images/products/tablet-ultra-1.jpg',
                'images/products/tablet-ultra-2.jpg',
            ]
        ]);
    }

    private function createProduct(array $data): void
    {
        $product = Product::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'],
            'price' => $data['price'],
            'sku' => $data['sku'],
            'stock' => $data['stock'],
            'is_featured' => $data['is_featured'],
            'category_id' => $data['category_id'],
        ]);

        foreach ($data['images'] as $index => $imagePath) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $imagePath,
                'is_primary' => $index === 0,
                'sort_order' => $index,
            ]);
        }
    }
}