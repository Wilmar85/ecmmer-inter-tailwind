<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;

// Crear un nuevo documento
$phpWord = new PhpWord();

// Añadir una sección al documento
$section = $phpWord->addSection();

// Título del documento
$section->addText(
    'Documentación del Panel de Administración - E-commerce InterEleticosf&A',
    ['bold' => true, 'size' => 16],
    ['alignment' => 'center']
);

$section->addTextBreak(2);

// Información de acceso
$section->addText(
    'Información de Acceso al Sistema',
    ['bold' => true, 'size' => 14, 'underline' => 'single']
);

$section->addText('Credenciales de Administrador');
$section->addListItem('URL de Acceso: /admin/login', 0, null, 'decimal');
$section->addListItem('Correo Electrónico: admin@ecomer-web.com', 0, null, 'decimal');
$section->addListItem('Contraseña: admin123', 0, null, 'decimal');

$section->addTextBreak(1);
$section->addText('Credenciales de Cliente Demo');
$section->addListItem('URL de Acceso: /login', 0, null, 'decimal');
$section->addListItem('Correo Electrónico: cliente@ecomer-web.com', 0, null, 'decimal');
$section->addListItem('Contraseña: cliente123', 0, null, 'decimal');

// Tabla de contenidos
$section->addPageBreak();
$section->addText(
    'Tabla de Contenidos',
    ['bold' => true, 'size' => 14, 'underline' => 'single']
);

$toc = [
    'Inicio de Sesión',
    'Panel de Control',
    'Gestión de Productos',
    'Gestión de Categorías',
    'Gestión de Pedidos',
    'Gestión de Usuarios',
    'Estadísticas y Reportes',
    'Consideraciones de Seguridad',
    'Soporte Técnico'
];

foreach ($toc as $item) {
    $section->addListItem($item, 0, null, 'decimal');
}

// Guardar el documento
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$outputFile = __DIR__ . '/Documentacion_Panel_Administracion_InterEleticosfA.docx';
$objWriter->save($outputFile);

echo "Documento generado exitosamente en: " . $outputFile . "\n";
