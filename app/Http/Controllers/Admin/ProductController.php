<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with(['category', 'subcategory'])->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    public function create() {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = \App\Models\Brand::all();
        return view('admin.products.create', compact('categories', 'subcategories', 'brands'));
    }
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        // Generar slug único
        $baseSlug = \Illuminate\Support\Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        if (empty($validated['sku'])) {
            $validated['sku'] = 'SKU-' . time() . '-' . mt_rand(1000, 9999);
        }
        $validated['active'] = $request->input('active', 0);
        // Normalizar la marca (Primera letra mayúscula, resto minúsculas)
        $brandName = ucfirst(mb_strtolower(trim($request->brand_name)));
        // Buscar marca existente (ignorando mayúsculas/minúsculas)
        $brand = \App\Models\Brand::whereRaw('LOWER(name) = ?', [mb_strtolower($brandName)])->first();
        if (!$brand) {
            // Si no existe, crearla
            $brand = \App\Models\Brand::create([
                'name' => $brandName,
                'slug' => \Illuminate\Support\Str::slug($brandName)
            ]);
        }
        $validated['brand_id'] = $brand->id;
        $product = Product::create($validated);
        $files = $request->file('images');
        if ($files) {
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
ImageOptimizer::optimize(storage_path('app/public/' . $path));
                    $product->images()->create(['image_path' => $path]);
                }
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
    }
    public function edit(Product $product) {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $brands = \App\Models\Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories', 'brands'));
    }
    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'active' => 'nullable|boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        // Generar slug único
        $baseSlug = \Illuminate\Support\Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;
        if (empty($validated['sku'])) {
            $validated['sku'] = 'SKU-' . time() . '-' . mt_rand(1000, 9999);
        }
        $validated['active'] = $request->input('active', 0);
        // Normalizar la marca (Primera letra mayúscula, resto minúsculas)
        $brandName = ucfirst(mb_strtolower(trim($request->brand_name)));
        // Buscar marca existente (ignorando mayúsculas/minúsculas)
        $brand = \App\Models\Brand::whereRaw('LOWER(name) = ?', [mb_strtolower($brandName)])->first();
        if (!$brand) {
            // Si no existe, crearla
            $brand = \App\Models\Brand::create([
                'name' => $brandName,
                'slug' => \Illuminate\Support\Str::slug($brandName)
            ]);
        }
        $validated['brand_id'] = $brand->id;
        $product->update($validated);
        if ($request->hasFile('images')) {
            // Elimina imágenes anteriores y sus archivos
            foreach ($product->images as $img) {
                \Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
ImageOptimizer::optimize(storage_path('app/public/' . $path));
                    $product->images()->create(['image_path' => $path]);
                }
            }
        }
        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado correctamente.');
    }
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado correctamente.');
    }
}
