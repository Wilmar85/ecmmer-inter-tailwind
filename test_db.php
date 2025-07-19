<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illware\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    // Verificar conexión
    DB::connection()->getPdo();
    echo "Conexión exitosa a la base de datos.\n";
    
    // Verificar si la tabla existe
    $tables = DB::select('SHOW TABLES');
    echo "Tablas en la base de datos:\n";
    foreach ($tables as $table) {
        $tableName = 'Tables_in_' . DB::getDatabaseName();
        echo "- " . $table->$tableName . "\n";
    }
    
    // Verificar si la tabla site_settings existe
    if (Schema::hasTable('site_settings')) {
        echo "\n¡La tabla site_settings existe!\n";
        $settings = DB::table('site_settings')->first();
        if ($settings) {
            echo "Datos en site_settings:\n";
            print_r($settings);
        } else {
            echo "La tabla site_settings está vacía.\n";
        }
    } else {
        echo "\nLa tabla site_settings NO existe.\n";
    }
    
} catch (\Exception $e) {
    echo "Error de conexión: " . $e->getMessage() . "\n";
}
