<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TestController extends Controller
{
    public function checkDatabase()
    {
        try {
            // Verificar conexión a la base de datos
            DB::connection()->getPdo();
            
            // Verificar tablas
            $tables = [
                'users',
                'support_tickets',
                'ticket_responses',
                'ticket_attachments',
                'ticket_ratings'
            ];
            
            $result = [];
            
            foreach ($tables as $table) {
                $result[$table] = Schema::hasTable($table) ? 'Existe' : 'No existe';
            }
            
            return response()->json([
                'status' => 'success',
                'tables' => $result
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al conectar con la base de datos: ' . $e->getMessage()
            ], 500);
        }
    }
}
