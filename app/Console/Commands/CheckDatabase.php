<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:check-tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica las tablas en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = [
            'users',
            'support_tickets',
            'ticket_responses',
            'ticket_attachments',
            'ticket_ratings'
        ];
        
        $this->info("Verificando tablas en la base de datos...\n");
        
        $headers = ['Tabla', 'Existe'];
        $rows = [];
        
        foreach ($tables as $table) {
            $exists = \Schema::hasTable($table) ? 'Sí' : 'No';
            $rows[] = [$table, $exists];
        }
        
        $this->table($headers, $rows);
        
        if (in_array('No', array_column($rows, 1))) {
            $this->warn("\nAlgunas tablas no existen. Ejecuta 'php artisan migrate' para crearlas.");
        } else {
            $this->info("\n¡Todas las tablas existen!");
        }
    }
}
