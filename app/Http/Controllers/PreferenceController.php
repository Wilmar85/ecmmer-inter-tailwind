<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function setLanguage(Request $request)
    {
        $lang = $request->input('lang', 'es');
        if (auth()->check()) {
            $user = auth()->user();
            $user->preferences()->updateOrCreate([], ['language' => $lang]);
            return back()->with('success', 'Idioma actualizado.');
        }
        return back()->withCookie(cookie('site_language', $lang, 60*24*30));
    }

    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'light');
        if (auth()->check()) {
            $user = auth()->user();
            $user->preferences()->updateOrCreate([], ['theme' => $theme]);
            return back()->with('success', 'Tema actualizado.');
        }
        return back()->withCookie(cookie('site_theme', $theme, 60*24*30));
    }

    public function addVisitedProduct(Request $request, $productId)
    {
        $visited = json_decode($request->cookie('visited_products', '[]'), true);
        $visited[] = $productId;
        $visited = array_unique($visited);
        return back()->withCookie(cookie('visited_products', json_encode($visited), 60*24*30));
    }
}
