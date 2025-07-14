<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $productImage): RedirectResponse
    {
        $productImage->delete();
        return back()->with('success', 'Imagen eliminada correctamente.');
    }
}
