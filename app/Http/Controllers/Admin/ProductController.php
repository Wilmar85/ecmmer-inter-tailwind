<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Services\ImageOptimizerService;
use Illuminate\Support\Facades\Storage;

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
        // Manejar la marca si se proporciona
        if ($request->has('brand_name') && !empty($request->brand_name)) {
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
        } else {
            // Si no se proporciona marca, establecer como NULL
            $validated['brand_id'] = null;
        }
        $product = Product::create($validated);
        $files = $request->file('images');
        if ($files) {
            if (!is_array($files)) {
                $files = [$files];
            }
            
            // Configuración de tamaños para las miniaturas
            $sizes = [
                ['name' => 'thumb', 'width' => 300, 'height' => 300],
                ['name' => 'medium', 'width' => 800, 'height' => 800],
                // Agregar más tamaños según sea necesario
            ];
            
            // Guardar la imagen sin optimización si no está disponible el servicio
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('images/products', $fileName, 'public');
                    
                    // Guardar la ruta relativa en la base de datos
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
            'images' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        // Generar slug único solo si el nombre ha cambiado
        if ($product->name !== $validated['name']) {
            $baseSlug = \Illuminate\Support\Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            $validated['slug'] = $slug;
        }

        if (empty($validated['sku'])) {
            $validated['sku'] = 'SKU-' . time() . '-' . mt_rand(1000, 9999);
        }

        $validated['active'] = $request->input('active', 0);
        
        // Manejar la marca si se proporciona
        if ($request->has('brand_name') && !empty($request->brand_name)) {
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
        } else {
            // Si no se proporciona marca, establecer como NULL
            $validated['brand_id'] = null;
        }
        
        // Actualizar el producto
        $product->update($validated);
        
        // Manejar la carga de imágenes adicionales
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            
            if (!is_array($files)) {
                $files = [$files];
            }
            
            // Asegurarse de que el directorio existe
            $storagePath = 'images/products';
            if (!file_exists(storage_path('app/public/' . $storagePath))) {
                \Illuminate\Support\Facades\File::makeDirectory(storage_path('app/public/' . $storagePath), 0755, true);
            }
            
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $fileName = time() . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs($storagePath, $fileName, 'public');
                    
                    // Guardar la ruta relativa en la base de datos
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
