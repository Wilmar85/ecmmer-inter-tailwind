<?php
// Ruta al archivo show.blade.php
$filePath = __DIR__ . '/resources/views/support/tickets/show.blade.php';

// Leer el contenido del archivo
$content = file_get_contents($filePath);

// Corregir el paréntesis adicional
$content = str_replace(
    "@if(!in_array(\$ticket->status, ['resolved', 'closed'])))",
    "@if(!in_array(\$ticket->status, ['resolved', 'closed']))",
    $content
);

// Guardar los cambios
file_put_contents($filePath, $content);

echo "Archivo corregido con éxito.\n";
