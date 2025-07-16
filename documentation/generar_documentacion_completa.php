<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Font;

// Crear un nuevo documento
$phpWord = new PhpWord();

// Definir estilos
$phpWord->addTitleStyle(1, ['size' => 16, 'bold' => true, 'color' => '2E86C1', 'spaceAfter' => 300]);
$phpWord->addTitleStyle(2, ['size' => 14, 'bold' => true, 'color' => '2874A6', 'spaceAfter' => 200]);
$phpWord->addTitleStyle(3, ['size' => 12, 'bold' => true, 'color' => '1B4F72', 'spaceAfter' => 150]);

// Añadir una sección al documento
$section = $phpWord->addSection();

// Título del documento
$section->addTitle('Documentación del Panel de Administración', 1);
$section->addText('E-commerce InterEleticosf&A', ['bold' => true, 'size' => 12, 'color' => '5D6D7E']);
$section->addTextBreak(2);

// Información de acceso
$section->addTitle('Información de Acceso al Sistema', 2);

$section->addText('Credenciales de Administrador', ['bold' => true]);
$section->addListItem('URL de Acceso: /admin/login', 0, null, 'decimal');
$section->addListItem('Correo Electrónico: admin@ecomer-web.com', 0, null, 'decimal');
$section->addListItem('Contraseña: admin123', 0, null, 'decimal');

$section->addTextBreak(1);
$section->addText('Credenciales de Cliente Demo', ['bold' => true]);
$section->addListItem('URL de Acceso: /login', 0, null, 'decimal');
$section->addListItem('Correo Electrónico: cliente@ecomer-web.com', 0, null, 'decimal');
$section->addListItem('Contraseña: cliente123', 0, null, 'decimal');

// Tabla de contenidos
$section->addPageBreak();
$section->addTitle('Tabla de Contenidos', 2);

$toc = [
    '1. Inicio de Sesión',
    '2. Panel de Control',
    '3. Gestión de Productos',
    '  3.1 Listado de Productos',
    '  3.2 Añadir Nuevo Producto',
    '  3.3 Editar Producto',
    '  3.4 Eliminar Producto',
    '4. Gestión de Categorías',
    '  4.1 Listado de Categorías',
    '  4.2 Añadir Nueva Categoría',
    '  4.3 Gestionar Subcategorías',
    '5. Gestión de Pedidos',
    '  5.1 Listado de Pedidos',
    '  5.2 Detalle del Pedido',
    '  5.3 Actualizar Estado del Pedido',
    '6. Gestión de Usuarios',
    '  6.1 Listado de Usuarios',
    '  6.2 Ver Detalles del Usuario',
    '  6.3 Editar Usuario',
    '7. Estadísticas y Reportes',
    '  7.1 Reporte de Ventas',
    '  7.2 Exportar Datos',
    '8. Consideraciones de Seguridad',
    '9. Soporte Técnico'
];

foreach ($toc as $item) {
    $section->addListItem($item, 0, null, 'decimal');
}

// Secciones de la documentación
$sections = [
    'Inicio de Sesión' => [
        'Para acceder al panel de administración, siga estos pasos:',
        '1. Abra su navegador web',
        '2. Ingrese la URL: /admin/login',
        '3. Introduzca sus credenciales de acceso',
        '4. Haga clic en "Iniciar Sesión"',
        '\nNota: Asegúrese de estar utilizando un navegador actualizado para la mejor experiencia.'
    ],
    'Panel de Control' => [
        'El panel de control muestra un resumen general de la tienda con las siguientes métricas:',
        '- Ingresos totales',
        '- Ventas por producto (top 10)',
        '- Ventas por región',
        '- Valor promedio de pedido',
        '- Tasa de conversión',
        '- Tasa de abandono de carrito',
        '- Número total de clientes',
        '- Nuevos clientes (últimos 30 días)'
    ],
    'Gestión de Productos' => [
        'Listado de Productos' => [
            'Acceda a: /admin/products',
            'Visualice todos los productos con información básica',
            'Busque productos por nombre, categoría o SKU',
            'Ordene productos por diferentes criterios'
        ],
        'Añadir Nuevo Producto' => [
            '1. Haga clic en "Añadir Producto"',
            '2. Complete el formulario con la información requerida',
            '3. Suba imágenes del producto',
            '4. Guarde los cambios'
        ]
    ]
];

// Añadir secciones al documento
foreach ($sections as $sectionTitle => $content) {
    $section->addPageBreak();
    $section->addTitle($sectionTitle, 2);
    
    if (is_array($content)) {
        foreach ($content as $subsection => $items) {
            if (is_array($items)) {
                $section->addTitle($subsection, 3);
                foreach ($items as $item) {
                    $section->addListItem($item, 0, null, 'decimal');
                }
            } else {
                $section->addText($items);
            }
        }
    } else {
        $section->addText($content);
    }
}

// Pie de página
$footer = $section->addFooter();
$footer->addPreserveText('Página {PAGE} de {NUMPAGES}.', null, ['alignment' => 'right']);

// Guardar el documento
$outputFile = __DIR__ . '/Documentacion_Completa_Panel_Administracion_InterEleticosfA.docx';
$phpWord->save($outputFile, 'Word2007', true);

echo "Documento generado exitosamente en: " . realpath($outputFile) . "\n";
