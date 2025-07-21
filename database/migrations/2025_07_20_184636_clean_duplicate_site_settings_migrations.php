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
        // Verificar si la tabla ya existe
        if (Schema::hasTable('site_settings')) {
            // Eliminar migraciones duplicadas de la tabla de migraciones
            \DB::table('migrations')
                ->whereIn('migration', [
                    '2025_07_18_054539_create_site_settings_table',
                    '2025_07_18_061410_create_site_settings_table_temp',
                    '2025_07_18_063418_create_site_settings_table_fixed',
                    '2025_07_18_064055_create_site_settings_table_final',
                    'temp_migration'
                ])
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se puede revertir esta operación de limpieza
    }
};
