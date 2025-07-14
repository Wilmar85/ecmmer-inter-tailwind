<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'images']);

        // Aplicar filtros
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $query->where('price', '>=', $min)->where('price', '<=', $max);
        } else {
            if ($request->filled('price_min')) {
                $query->where('price', '>=', $request->price_min);
            }
            if ($request->filled('price_max')) {
                $query->where('price', '<=', $request->price_max);
            }
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();
$brands = \App\Models\Brand::all();

        return view('shop.index', compact('products', 'categories', 'brands'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        if (empty($validated['sku'])) {
            $validated['sku'] = 'SKU-' . time() . '-' . mt_rand(1000, 9999);
        }
        $product = Product::create($validated);

        $imageErrors = [];
        $imageSuccess = false;
        $files = $request->file('images');
        if ($files) {
            // Si es solo un archivo, conviértelo en array
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('products', 'public');
                    if ($path && file_exists(storage_path('app/public/' . $path))) {
                        $product->images()->create(['image_path' => $path]);
                        $imageSuccess = true;
                    } else {
                        $imageErrors[] = $image->getClientOriginalName();
                    }
                } else {
                    $imageErrors[] = $image ? $image->getClientOriginalName() : 'Archivo no válido';
                }
            }
        }
        if (!$imageSuccess && empty($imageErrors) && $request->hasFile('images')) {
            $imageErrors[] = 'No se recibió ningún archivo válido.';
        }
        if (count($imageErrors) > 0) {
            return redirect()->route('products.index')
                ->with('success', 'Producto creado, pero hubo errores al subir las siguientes imágenes: ' . implode(', ', $imageErrors));
        }
        if (!$imageSuccess && !$request->hasFile('images')) {
            return redirect()->route('products.index')
                ->with('success', 'Producto creado, pero no se subió ninguna imagen.');
        }

        if (count($imageErrors) > 0) {
            return redirect()->route('products.index')
                ->with('success', 'Producto creado, pero hubo errores al subir las siguientes imágenes: ' . implode(', ', $imageErrors));
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $this->authorize('update', $product);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

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
                    $product->images()->create(['image_path' => $path]);
                }
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}