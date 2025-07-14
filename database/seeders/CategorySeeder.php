<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electrónicos',
                'description' => 'Productos electrónicos y gadgets',
                'subcategories' => [
                    ['name' => 'Smartphones', 'description' => 'Teléfonos inteligentes y accesorios'],
                    ['name' => 'Laptops', 'description' => 'Computadoras portátiles y accesorios'],
                    ['name' => 'Tablets', 'description' => 'Tablets y accesorios'],
                ]
            ],
            [
                'name' => 'Ropa',
                'description' => 'Ropa y accesorios de moda',
                'subcategories' => [
                    ['name' => 'Hombre', 'description' => 'Ropa para hombre'],
                    ['name' => 'Mujer', 'description' => 'Ropa para mujer'],
                    ['name' => 'Niños', 'description' => 'Ropa para niños'],
                ]
            ],
            [
                'name' => 'Hogar',
                'description' => 'Artículos para el hogar',
                'subcategories' => [
                    ['name' => 'Muebles', 'description' => 'Muebles para el hogar'],
                    ['name' => 'Decoración', 'description' => 'Artículos decorativos'],
                    ['name' => 'Cocina', 'description' => 'Utensilios y electrodomésticos'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
            ]);

            foreach ($categoryData['subcategories'] as $subcategoryData) {
                Category::create([
                    'name' => $subcategoryData['name'],
                    'slug' => Str::slug($subcategoryData['name']),
                    'description' => $subcategoryData['description'],
                    'parent_id' => $category->id,
                ]);
            }
        }
    }
}