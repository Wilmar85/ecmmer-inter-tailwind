<?php

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\BrandController;

// Ruta para actualizar el estado de una orden en el panel de administración
Route::post('/admin/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Preferencias del usuario (cookies)
Route::post('/preferencias/idioma', [PreferenceController::class, 'setLanguage'])->name('preferences.language');
Route::post('/preferencias/tema', [PreferenceController::class, 'setTheme'])->name('preferences.theme');
Route::post('/preferencias/visitado/{productId}', [PreferenceController::class, 'addVisitedProduct'])->name('preferences.visited');

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Políticas y Términos
Route::get('/politica-de-privacidad', function () {
    return view('policies.privacy');
})->name('privacy');

Route::get('/terminos-y-condiciones', function () {
    return view('terminos');
})->name('terms');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Rutas del administrador
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Configuración del sitio
    Route::get('/settings', [AdminSiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/{setting}', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    
    // Sliders
    Route::resource('sliders', AdminSliderController::class)->except(['show']);
    Route::post('sliders/update-order', [AdminSliderController::class, 'updateOrder'])->name('sliders.update-order');
});

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');

Route::get('/debug/images', [DebugController::class, 'checkImages']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Ruta API para obtener el número de productos en el carrito (AJAX)
    Route::get('/api/cart/count', [\App\Http\Controllers\CartController::class, 'cartCount'])->name('cart.count');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/contact', [ProfileController::class, 'updateContact'])->name('profile.contact.update');
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
    Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('can:view,order')->name('orders.show');

    // Rutas de checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/validate-stock', [CheckoutController::class, 'validateStock'])->name('checkout.validate-stock');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->middleware('can:view,order')->name('checkout.success');
    Route::get('/checkout/failure/{order}', [CheckoutController::class, 'failure'])->middleware('can:view,order')->name('checkout.failure');
    Route::get('/checkout/pending/{order}', [CheckoutController::class, 'pending'])->middleware('can:view,order')->name('checkout.pending');
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

// Ruta para verificar la base de datos
Route::get('/test-db', [App\Http\Controllers\TestController::class, 'checkDatabase']);

// Ruta de prueba
Route::get('/test-route', function () {
    return response()->json([
        'message' => 'Ruta de prueba funcionando correctamente',
        'time' => now()
    ]);
})->name('test.route');

require __DIR__.'/auth.php';
require __DIR__.'/support.php';
