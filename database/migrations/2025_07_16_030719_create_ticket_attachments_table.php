<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('ticket_attachments')) {
            Schema::create('ticket_attachments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ticket_response_id')->constrained('ticket_responses')->onDelete('cascade');
                $table->string('original_name');
                $table->string('path');
                $table->string('mime_type');
                $table->unsignedBigInteger('size');
                $table->timestamps();
                
                // Agregar índice para mejorar el rendimiento
                $table->index('ticket_response_id');
            });
            
            \Log::info('Tabla ticket_attachments creada exitosamente');
        } else {
            \Log::info('La tabla ticket_attachments ya existe');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_attachments', function (Blueprint $table) {
            // Eliminar la clave foránea primero para evitar errores
            $table->dropForeign(['ticket_response_id']);
        });
        
        Schema::dropIfExists('ticket_attachments');
        \Log::info('Tabla ticket_attachments eliminada');
    }
};
