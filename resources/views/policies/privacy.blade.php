@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-section {
        animation: fadeIn 0.4s ease-out forwards;
        opacity: 0;
    }
    
    .gradient-text {
        color: #1a1a1a;
        font-weight: 700;
    }
    
    .prose a {
        color: #4f46e5;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .prose a:hover {
        color: #4338ca;
        text-decoration: underline;
    }
    
    .prose ul > li::before {
        background-color: #4f46e5;
    }
    
    .prose h2 {
        color: #1a1a1a;
        font-weight: 600;
        margin-top: 2em;
    }
    
    .prose p {
        color: #1f2937;
        line-height: 1.5;
        margin-bottom: 1em;
    }
    
    .prose li {
        color: #1f2937;
        line-height: 1.5;
        margin-bottom: 0.5em;
    }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    <span class="gradient-text">Política de Privacidad</span>
                </h1>
                <p class="text-gray-600">
                    Última actualización: {{ now()->format('d/m/Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="bg-white py-8 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
                <div class="prose max-w-none">
                    <p class="text-gray-800 mb-4">
                        En cumplimiento con la normativa de protección de datos personales, le informamos sobre nuestra política de privacidad.
                    </p>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">1. Responsable del Tratamiento</h2>
                        <p class="text-gray-800">
                            Los datos personales recabados serán tratados por <strong>{{ config('app.name') }}</strong>,
                            con domicilio en [Dirección de la Empresa], como responsable del tratamiento de sus datos.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">2. Finalidad del Tratamiento</h2>
                        <p class="text-gray-800 mb-3">
                            Sus datos personales serán utilizados para las siguientes finalidades:
                        </p>
                        <ul class="list-disc pl-5 text-gray-800 space-y-1">
                            <li>Gestión de pedidos y envíos</li>
                            <li>Atención al cliente y resolución de dudas</li>
                            <li>Envío de información comercial, si ha dado su consentimiento</li>
                            <li>Cumplimiento de obligaciones legales</li>
                        </ul>
                    </section>

                    <section class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">3. Legitimación</h2>
                        <p class="text-gray-800">
                            La base legal para el tratamiento de sus datos es la ejecución del contrato de compraventa, 
                            el consentimiento para el envío de comunicaciones comerciales y el cumplimiento de obligaciones legales.
                        </p>
                    </section>

                    <section class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">4. Destinatarios</h2>
                        <p class="text-gray-800">
                            Sus datos podrán ser comunicados a empresas de transporte para la gestión del envío de productos 
                            y a entidades financieras para el cobro de los mismos.
                        </p>
                    </section>

                    <section class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Derechos</h2>
                        <p class="text-gray-800">
                            Usted tiene derecho a acceder, rectificar, oponerse, suprimir, limitar el tratamiento, 
                            portabilidad de sus datos y a retirar el consentimiento en cualquier momento.
                        </p>
                        <p class="text-gray-800 mt-2">
                            Puede ejercer estos derechos enviando un correo electrónico a 
                            <a href="mailto:interelectricosaf@gmail.com" class="text-primary-600 hover:underline">
                                interelectricosaf@gmail.com
                            </a>
                            o mediante carta dirigida a nuestra dirección.
                        </p>
                    </section>

                    <section class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Plazo de Conservación</h2>
                        <p class="text-gray-800">
                            Sus datos se conservarán mientras exista una relación comercial o durante los años necesarios 
                            para cumplir con las obligaciones legales.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">7. Contacto</h2>
                        <p class="text-gray-800">
                            Para cualquier consulta sobre protección de datos, puede contactarnos en 
                            <a href="mailto:interelectricosaf@gmail.com" class="text-primary-600 hover:underline">
                                interelectricosaf@gmail.com
                            </a>.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
