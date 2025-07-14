@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Política de Cookies</h1>
        <p class="mb-4">
            Este sitio web utiliza cookies para mejorar la experiencia del usuario, analizar el tráfico y personalizar el contenido, cumpliendo con la <b>Ley 1581 de 2012</b>, el <b>Decreto 1377 de 2013</b> y las directrices de la <b>Superintendencia de Industria y Comercio (SIC)</b> de Colombia.
        </p>
        <h2 class="text-xl font-semibold mt-4 mb-2">¿Qué son las cookies?</h2>
        <p class="mb-4">
            Las cookies son pequeños archivos de texto que se almacenan en su dispositivo cuando visita un sitio web. Sirven para recordar sus preferencias y mejorar su experiencia de navegación.
        </p>
        <h2 class="text-xl font-semibold mt-4 mb-2">¿Qué tipos de cookies usamos?</h2>
        <ul class="list-disc ml-8 mb-4">
            <li><b>Cookies necesarias:</b> Permiten el funcionamiento básico del sitio.</li>
            <li><b>Cookies de análisis:</b> Nos ayudan a entender cómo interactúan los usuarios con el sitio.</li>
            <li><b>Cookies de personalización:</b> Recuerdan sus preferencias.</li>
        </ul>
        <h2 class="text-xl font-semibold mt-4 mb-2">Consentimiento</h2>
        <p class="mb-4">
            Al navegar por este sitio, usted acepta el uso de cookies conforme a esta política. Puede configurar su navegador para rechazar cookies, pero esto puede afectar la funcionalidad del sitio.
        </p>
        <h2 class="text-xl font-semibold mt-4 mb-2">Sus derechos</h2>
        <p class="mb-4">
            Usted puede solicitar información, actualización, rectificación y supresión de sus datos personales. Para ejercer estos derechos, contáctenos a través del formulario de contacto.
        </p>
        <h2 class="text-xl font-semibold mt-4 mb-2">Contacto</h2>
        <p>
            Si tiene preguntas sobre nuestra política de cookies, escríbanos desde la sección de <a href="{{ route('contact') }}" class="text-blue-600 underline">Contacto</a>.
        </p>
    </div>
</div>
@endsection
