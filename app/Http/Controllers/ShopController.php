<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'images']);

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filtro por categoría
        if ($request->filled('category')) {
            $categorySlug = $request->get('category');
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Filtro por precio mínimo
        if ($request->filled('price_min')) {
            $query->where('price', '>=', floatval($request->get('price_min')));
        }

        // Filtro por precio máximo
        if ($request->filled('price_max')) {
            $query->where('price', '<=', floatval($request->get('price_max')));
        }

        // Filtro de stock
        if ($request->filled('stock')) {
            if ($request->get('stock') === 'in') {
                $query->where('stock', '>', 0);
            } elseif ($request->get('stock') === 'out') {
                $query->where('stock', '<=', 0);
            }
        }

        // Ordenar
        switch ($request->get('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->appends($request->except('page'));
        $categories = Category::all();

        return view('products.shop', compact('products', 'categories'));
    }
}