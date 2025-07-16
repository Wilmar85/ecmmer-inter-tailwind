<?php

use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\TicketRatingController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación requerida
Route::middleware(['auth'])->group(function () {
    // Tickets de soporte
    Route::prefix('support')->name('support.')->group(function () {
        // Rutas de recursos para tickets
        Route::resource('tickets', SupportTicketController::class, [
            'names' => 'tickets',
            'parameters' => ['tickets' => 'ticket']
        ])->except(['edit', 'update']);

        // Respuestas a tickets
        Route::post('tickets/{ticket}/response', [SupportTicketController::class, 'storeResponse'])
            ->name('tickets.response');

        // Actualizar estado de tickets
        Route::post('tickets/{ticket}/status', [SupportTicketController::class, 'updateStatus'])
            ->name('tickets.update-status');

        // Cargar archivos adjuntos
        Route::post('tickets/{ticket}/upload', [SupportTicketController::class, 'uploadAttachment'])
            ->name('tickets.upload');

        // Descargar archivos adjuntos
        Route::get('tickets/attachments/{attachment}', [SupportTicketController::class, 'downloadAttachment'])
            ->name('tickets.attachment.download');
            
        // Rutas para calificaciones de tickets
        Route::post('tickets/{ticket}/rate', [TicketRatingController::class, 'store'])
            ->name('tickets.rate');
            
        Route::put('ratings/{rating}', [TicketRatingController::class, 'update'])
            ->name('ratings.update');
            
        Route::delete('ratings/{rating}', [TicketRatingController::class, 'destroy'])
            ->name('ratings.destroy');
    });
});
