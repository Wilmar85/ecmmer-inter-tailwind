<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Livewire\Admin\ContactInformationNew;

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'dashboardData'])->name('admin.dashboard.data');
    
    // Resources
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    
    // Product Images
    Route::delete('product-images/{productImage}', [App\Http\Controllers\Admin\ProductImageController::class, 'destroy'])->name('admin.product-images.destroy');
    
    // Contact Information
    Route::get('/contact-information', ContactInformationNew::class)->name('admin.contact-information');
});
