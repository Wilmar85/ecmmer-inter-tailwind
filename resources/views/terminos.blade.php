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
    
    .prose p, .prose li {
        color: #1f2937;
        line-height: 1.5;
        margin-bottom: 1em;
    }
</style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                    <span class="gradient-text">Términos y Condiciones</span>
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
                    <p class="text-gray-800 mb-6">
                        Bienvenido a {{ config('app.name') }. Al acceder y utilizar nuestro sitio web, usted acepta los siguientes términos y condiciones. Le recomendamos que los lea detenidamente antes de realizar cualquier compra o utilizar nuestros servicios.
                    </p>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">1. Uso del Sitio Web</h2>
                        <p class="text-gray-800">
                            El acceso y uso de este sitio web está sujeto a los siguientes términos y condiciones, así como a todas las leyes aplicables. Al acceder y navegar por este sitio, usted acepta cumplir con estos términos y condiciones sin reservas.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">2. Registro de Usuario</h2>
                        <p class="text-gray-800">
                            Para realizar compras en nuestro sitio, deberá crear una cuenta de usuario proporcionando información precisa y completa. Usted es responsable de mantener la confidencialidad de su contraseña y de todas las actividades que ocurran bajo su cuenta.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">3. Compras y Pagos</h2>
                        <p class="text-gray-800">
                            Todas las compras están sujetas a disponibilidad. Nos reservamos el derecho de limitar las cantidades de productos que ofrecemos. Los precios de los productos están sujetos a cambios sin previo aviso.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">4. Propiedad Intelectual</h2>
                        <p class="text-gray-800">
                            Todo el contenido de este sitio web, incluyendo textos, gráficos, logotipos, imágenes y software, es propiedad de {{ config('app.name') } o sus proveedores de contenido y está protegido por las leyes de propiedad intelectual.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">5. Limitación de Responsabilidad</h2>
                        <p class="text-gray-800">
                            {{ config('app.name') } no será responsable por daños indirectos, incidentales, especiales, consecuentes o punitivos que resulten del uso o la imposibilidad de utilizar este sitio web o su contenido.
                        </p>
                    </section>

                    <section class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">6. Modificaciones</h2>
                        <p class="text-gray-800">
                            Nos reservamos el derecho de modificar estos términos y condiciones en cualquier momento. Los cambios entrarán en vigor inmediatamente después de su publicación en el sitio. El uso continuado del sitio después de dichos cambios constituirá su aceptación de los mismos.
                        </p>
                    </section>

                    <section class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">7. Ley Aplicable</h2>
                        <p class="text-gray-800">
                            Estos términos y condiciones se regirán e interpretarán de acuerdo con las leyes de Colombia. Cualquier disputa que surja en relación con estos términos y condiciones estará sujeta a la jurisdicción exclusiva de los tribunales de Bucaramanga.
                        </p>
                    </section>

                    <section>
                        <h2 class="text-xl font-semibold text-gray-900 mb-3">8. Contacto</h2>
                        <p class="text-gray-800">
                            Si tiene alguna pregunta sobre estos términos y condiciones, puede contactarnos en 
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
