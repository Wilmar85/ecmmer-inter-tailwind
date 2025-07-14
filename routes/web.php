<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Ruta para actualizar el estado de una orden en el panel de administración
Route::post('/admin/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreferenceController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Preferencias del usuario (cookies)
Route::post('/preferencias/idioma', [PreferenceController::class, 'setLanguage'])->name('preferences.language');
Route::post('/preferencias/tema', [PreferenceController::class, 'setTheme'])->name('preferences.theme');
Route::post('/preferencias/visitado/{productId}', [PreferenceController::class, 'addVisitedProduct'])->name('preferences.visited');

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');

use App\Http\Controllers\AboutController;
Route::get('/about', [AboutController::class, 'index'])->name('about');

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\BrandController;

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Ruta API para obtener el número de productos en el carrito (AJAX)
    Route::get('/api/cart/count', [\App\Http\Controllers\CartController::class, 'cartCount'])->name('cart.count');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas del carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addItem'])->name('cart.add');
    Route::patch('/cart/update/{item}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/cart/remove/{item}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Rutas de pedidos
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Rutas de checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/validate-stock', [CheckoutController::class, 'validateStock'])->name('checkout.validate-stock');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure/{order}', [CheckoutController::class, 'failure'])->name('checkout.failure');
    Route::get('/checkout/pending/{order}', [CheckoutController::class, 'pending'])->name('checkout.pending');
});


// Rutas públicas de productos
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Category routes
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Webhook para MercadoPago
Route::post('/webhooks/mercadopago', [WebhookController::class, 'handleMercadoPago'])
    ->name('webhooks.mercadopago')
    ->middleware('api');

// Wompi payment routes
Route::get('/orders/{order}/wompi-checkout', [\App\Http\Controllers\WompiController::class, 'checkout'])->name('wompi.checkout');
Route::get('/orders/{order}/wompi-widget', [\App\Http\Controllers\WompiController::class, 'widget'])->name('wompi.widget');
Route::get('/orders/{order}/wompi-callback', [\App\Http\Controllers\WompiController::class, 'callback'])->name('wompi.callback');
Route::post('/webhooks/wompi', [\App\Http\Controllers\WompiController::class, 'webhook'])->name('webhooks.wompi')->middleware('api');

require __DIR__.'/auth.php';
