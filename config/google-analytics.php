<?php
return [
    // ID de la propiedad GA4 (ejemplo: '123456789')
    'property_id' => env('GA4_PROPERTY_ID', ''),
    // Ruta al archivo de credenciales de Google Service Account
    'credentials_json' => env('GA4_CREDENTIALS_JSON', storage_path('app/ga-credentials.json')),
];
