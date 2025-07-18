<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WhatsAppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Aquí puedes agregar rutas de API en el futuro.
// Ruta para obtener el número de WhatsApp del botón flotante
Route::middleware('auth:web')->get('/user/whatsapp-float-number', [WhatsAppController::class, 'getFloatButtonNumber']);
