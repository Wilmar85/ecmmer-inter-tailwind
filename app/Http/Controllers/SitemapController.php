<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'))
            ->add(Url::create('/shop'));

        // Agregar categorías
        foreach (\App\Models\Category::all() as $category) {
            $sitemap->add(Url::create('/categories/' . $category->slug));
        }
        // Agregar productos
        foreach (\App\Models\Product::where('active', true)->get() as $product) {
            $sitemap->add(Url::create('/products/' . $product->slug));
        }

        return $sitemap->toResponse(request());
    }
}
