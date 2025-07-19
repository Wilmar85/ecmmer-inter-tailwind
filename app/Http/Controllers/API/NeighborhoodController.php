<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $city = $request->query('city', 'Bucaramanga');
        
        // Por ahora solo manejamos Bucaramanga
        if ($city !== 'Bucaramanga') {
            return response()->json([
                'success' => false,
                'message' => 'Solo se soporta la ciudad de Bucaramanga por el momento.'
            ], 400);
        }
        
        $neighborhoods = [
            'Bucaramanga', 'Cabecera', 'Alarcón', 'Antonia Santos', 'Provenza', 
            'La Concordia', 'Mutis', 'San Alonso', 'San Francisco', 'La Universidad', 
            'Sotomayor', 'Girardot', 'La Feria', 'La Floresta', 'El Prado', 
            'La Victoria', 'San Pedro', 'El Rocío', 'Las Américas', 'San Mateo',
            'San Miguel', 'La Joya', 'La Cumbre', 'El Pablón', 'La Libertad',
            'La Inmaculada', 'San Luis', 'La Paz', 'San Rafael', 'El Bosque',
            'La Esperanza', 'El Prado Norte', 'El Prado Sur', 'San Martín', 'San José',
            'La Floresta Norte', 'La Floresta Sur', 'San Francisco Oriental', 
            'San Francisco Occidental', 'La Rosita', 'La Salle', 'La Merced',
            'San Cristóbal Norte', 'San Cristóbal Sur', 'La Aurora', 'El Carmen',
            'Los Pinos', 'Los Sauces', 'Villa del Prado', 'Villa Rosita', 'Villa Adelaida',
            'Villa Country', 'Villa del Sol', 'Villa del Pilar', 'Villa del Río',
            'Villa San Diego', 'Villa Helena', 'Villa Silvia', 'Villa Mercedes',
            'Villa del Parque', 'Villa del Lago', 'Villa del Campo', 'Villa del Río Sur',
            'Villa del Río Norte', 'Villa del Río Centro', 'Villa del Río Oriental',
            'Villa del Río Occidental', 'Villa del Río 1', 'Villa del Río 2',
            'Villa del Río 3', 'Villa del Río 4', 'Villa del Río 5', 'Villa del Río 6',
            'Villa del Río 7', 'Villa del Río 8', 'Villa del Río 9', 'Villa del Río 10',
            'Villa del Río 11', 'Villa del Río 12', 'Villa del Río 13', 'Villa del Río 14',
            'Villa del Río 15', 'Villa del Río 16', 'Villa del Río 17', 'Villa del Río 18',
            'Villa del Río 19', 'Villa del Río 20', 'Villa del Río 21', 'Villa del Río 22',
            'Villa del Río 23', 'Villa del Río 24', 'Villa del Río 25'
        ];
        
        sort($neighborhoods); // Ordenar alfabéticamente
        
        return response()->json([
            'success' => true,
            'data' => [
                'city' => $city,
                'neighborhoods' => $neighborhoods
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
