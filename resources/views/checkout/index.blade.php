<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finalizar Compra') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Formulario de Envío y Pago -->
                <div class="order-2 md:order-1 md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Información de Envío y Pago</h3>
                        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form" class="space-y-4">
                            @csrf
                            
                            <!-- Información Personal -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                                    <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                    <input type="tel" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                </div>
                            </div>

                            <!-- Método de Envío -->
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Método de Envío</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" id="delivery" value="delivery" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                                        <label for="delivery" class="ml-2 block text-sm text-gray-700">Envío a Domicilio</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="shipping_method" id="pickup" value="pickup" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <label for="pickup" class="ml-2 block text-sm text-gray-700">Recoger en Tienda</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Dirección de Envío (visible solo para envío a domicilio) -->
                            <div id="shipping-address-section">
                                <div class="mt-4">
                                    <label for="street" class="block text-sm font-medium text-gray-700">Dirección</label>
                                    <input type="text" name="street" id="street" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700">Ciudad</label>
                                        <select name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Seleccione una ciudad</option>
                                            <option value="Bogotá">Bogotá</option>
                                            <option value="Medellín">Medellín</option>
                                            <option value="Cali">Cali</option>
                                            <option value="Barranquilla">Barranquilla</option>
                                            <option value="Cartagena">Cartagena</option>
                                            <option value="Bucaramanga">Bucaramanga</option>
                                            <option value="Pereira">Pereira</option>
                                            <option value="Manizales">Manizales</option>
                                            <option value="Cúcuta">Cúcuta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="neighborhood" class="block text-sm font-medium text-gray-700">Barrio</label>
                                        <select name="neighborhood" id="neighborhood" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                            <option value="">Seleccione un barrio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Manejo de barrios por ciudad
                                const neighborhoodsByCity = {
                                    'Bogotá': [
                                        'Chapinero', 'Usaquén', 'Teusaquillo', 'Suba', 'Fontibón', 'Kennedy', 'Engativá', 'Barrios Unidos', 'Puente Aranda', 'Antonio Nariño', 'Santa Fe', 'San Cristóbal', 'Ciudad Bolívar', 'Tunjuelito', 'Bosa', 'Rafael Uribe Uribe', 'La Candelaria', 'Los Mártires', 'Sumapaz'
                                    ],
                                    'Medellín': [
                                        'El Poblado', 'Laureles', 'Belen', 'Castilla', 'Robledo', 'Manrique', 'Aranjuez', 'Buenos Aires', 'San Javier', 'La América', 'La Candelaria', 'Doce de Octubre', 'Guayabal', 'San Antonio de Prado', 'Santa Cruz', 'Popular', 'Villa Hermosa'
                                    ],
                                    'Cali': [
                                        'San Fernando', 'Granada', 'El Peñón', 'Aguablanca', 'Ciudad Jardín', 'San Antonio', 'La Flora', 'Versalles', 'El Ingenio', 'Santa Mónica', 'La Merced', 'Alfonso López', 'Siloé', 'Meléndez', 'San Nicolás', 'Sucre'
                                    ],
                                    'Barranquilla': [
                                        'El Prado', 'Alto Prado', 'Villa Country', 'Ciudad Jardín', 'Boston', 'La Concepción', 'Las Delicias', 'San Vicente', 'Rebolo', 'La Unión', 'Las Nieves', 'Montecristo', 'La Ceiba', 'El Recreo'
                                    ],
                                    'Cartagena': [
                                        'Getsemaní', 'Bocagrande', 'Manga', 'El Cabrero', 'La Matuna', 'Pie de la Popa', 'Crespo', 'Chambacú', 'San Diego', 'Torices', 'La Boquilla', 'El Bosque', 'Olaya Herrera'
                                    ],
                                    'Bucaramanga': [
                                        'Cabecera', 'Alarcón', 'Antonia Santos', 'Provenza', 'La Concordia', 'Mutis', 'San Alonso', 'San Francisco', 'La Universidad', 'Sotomayor', 'Girardot', 'La Feria'
                                    ],
                                    'Pereira': [
                                        'Cuba', 'Alamos', 'Centro', 'Boston', 'San Joaquín', 'Villavicencio', 'El Jardín', 'San Nicolás', 'La Circunvalar', 'Villa Santana', 'Kennedy', 'San Fernando'
                                    ],
                                    'Manizales': [
                                        'Palogrande', 'La Enea', 'Chipre', 'El Cable', 'San Jorge', 'La Francia', 'Centro', 'Malhabar', 'Los Rosales', 'Villa Pilar', 'Campohermoso', 'Villahermosa'
                                    ],
                                    'Cúcuta': [
                                        'La Ceiba', 'Caobos', 'Centro', 'La Riviera', 'Guaimaral', 'San Luis', 'San Rafael', 'El Contento', 'La Playa', 'Motilones', 'Los Caobos', 'La Cabrera'
                                    ]
                                };
                                const citySelect = document.getElementById('city');
                                if (citySelect) {
                                    citySelect.addEventListener('change', function() {
                                        const city = this.value;
                                        const neighborhoodSelect = document.getElementById('neighborhood');
                                        if (neighborhoodSelect) {
                                            neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';
                                            if (neighborhoodsByCity[city]) {
                                                neighborhoodsByCity[city].forEach(function(barrio) {
                                                    const opt = document.createElement('option');
                                                    opt.value = barrio;
                                                    opt.textContent = barrio;
                                                    neighborhoodSelect.appendChild(opt);
                                                });
                                            }
                                        }
                                    });
                                }
                                </script>
    

                            </div>

                            <!-- Método de Pago -->
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700">Método de Pago</label>
                                <div class="flex items-center space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="payment_method" id="payment_cash" value="cash" class="form-radio h-4 w-4 text-indigo-600" checked>
                                        <span class="ml-2">Pago en Efectivo</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="payment_method" id="payment_proof_radio" value="comprobante" class="form-radio h-4 w-4 text-indigo-600">
                                        <span class="ml-2">Comprobante de Pago (subir imagen)</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Comprobante de Pago -->
                            <div class="mt-6" id="comprobante-section" style="display:none;">
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700">Comprobante de Pago (imagen)</label>
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <p class="text-xs text-gray-500 mt-1">Adjunta una foto o captura del comprobante de pago para separar tu compra.</p>
                            </div>

                            <script>
                            // Lógica combinada para métodos de pago y envío
function updateCheckoutFields() {
    // DEPURACIÓN: Verifica si la función se ejecuta y el estado de los radios
    console.log('updateCheckoutFields ejecutada');
    const isDelivery = document.getElementById('delivery').checked;
    const paymentProofRadio = document.getElementById('payment_proof_radio');
    console.log('isDelivery:', isDelivery, 'paymentProofRadio.checked:', paymentProofRadio.checked);

    const street = document.getElementById('street');
    const city = document.getElementById('city');
    const neighborhood = document.getElementById('neighborhood');
    const paymentProofInput = document.getElementById('payment_proof');
    const paymentCashRadio = document.getElementById('payment_cash');
    const comprobanteSection = document.getElementById('comprobante-section');
    // Dirección solo requerida/habilitada si es delivery
    street.required = isDelivery;
    city.required = isDelivery;
    neighborhood.required = isDelivery;
    street.disabled = !isDelivery;
    city.disabled = !isDelivery;
    neighborhood.disabled = !isDelivery;
    // Ocultar/mostrar sección dirección
    const shippingSection = document.getElementById('shipping-address-section');
    shippingSection.style.display = isDelivery ? '' : 'none';
    if (!isDelivery) {
        street.value = '';
        city.value = '';
        neighborhood.value = '';
    }
    // Comprobante solo requerido si se selecciona comprobante
    if (paymentProofRadio.checked) {
        comprobanteSection.style.display = 'block';
        paymentProofInput.required = true;
    } else {
        comprobanteSection.style.display = 'none';
        paymentProofInput.required = false;
        paymentProofInput.value = '';
    }
}

document.getElementById('delivery').addEventListener('change', updateCheckoutFields);
document.getElementById('pickup').addEventListener('change', updateCheckoutFields);
document.getElementById('payment_cash').addEventListener('change', updateCheckoutFields);
document.getElementById('payment_proof_radio').addEventListener('change', updateCheckoutFields);
// Ejecuta siempre después de definir la función y listeners
updateCheckoutFields();
document.addEventListener('DOMContentLoaded', updateCheckoutFields);

                            
                            </script>

                            <div class="mt-6">
                                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Confirmar Pedido
                                </button>
                            </div>
                            <script>
    // Garantiza consistencia antes de enviar el formulario
    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const paymentCash = document.getElementById('payment_cash').checked;
        const pickupRadio = document.getElementById('pickup');
        const deliveryRadio = document.getElementById('delivery');
        // Habilita ambos radios antes de enviar
        pickupRadio.disabled = false;
        deliveryRadio.disabled = false;
        if (paymentCash) {
            pickupRadio.checked = true;
            deliveryRadio.checked = false;
        }
    });
    </script>
</form>
                    </div>
                </div>

                <!-- Resumen del Pedido -->
                <div class="order-1 md:order-2 md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:sticky md:top-28">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Resumen del Pedido</h3>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between items-center py-2 border-b">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->product->name }}</p>
                                    <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                                </div>
                                <p class="text-sm font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                            </div>
                            @endforeach

                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">IVA (19%)</span>
                                    <span class="font-medium">${{ number_format($subtotal * 0.19, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Envío</span>
                                    <span id="shipping-cost" class="font-medium">${{ number_format($shipping, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-base font-medium">
                                    <span class="text-gray-900">Total</span>
                                    <span id="total-amount" class="text-gray-900">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Función para manejar la visibilidad de los campos de dirección y actualizar costos
        function toggleShippingFields() {
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
            const shippingAddressSection = document.getElementById('shipping-address-section');
            const shippingFields = shippingAddressSection.querySelectorAll('input');
            const shippingCost = shippingMethod === 'delivery' ? 10 : 0;
            
            // Actualizar visibilidad y estado de los campos
            shippingAddressSection.style.display = shippingMethod === 'delivery' ? 'block' : 'none';
            shippingFields.forEach(field => {
                field.required = shippingMethod === 'delivery';
                field.disabled = shippingMethod !== 'delivery';
                if (shippingMethod !== 'delivery') field.value = '';
            });

            // Actualizar costos y etiquetas
            updateOrderSummary(shippingCost);
        }

        // Función para actualizar el resumen del pedido
        function updateOrderSummary(shippingCost) {
            const subtotal = {{ $subtotal }};
            const iva = subtotal * 0.19;
            const total = subtotal + iva + shippingCost;
            const shippingMethod = document.querySelector('input[name="shipping_method"]:checked').value;
            
            // Actualizar montos
            document.getElementById('shipping-cost').textContent = `$${shippingCost.toFixed(2)}`;
            document.getElementById('total-amount').textContent = `$${total.toFixed(2)}`;
            
            // Actualizar etiqueta de envío
            const shippingLabel = document.querySelector('#shipping-cost').parentElement.querySelector('.text-gray-600');
            shippingLabel.textContent = shippingMethod === 'pickup' ? 'Envío (Retiro en Tienda)' : 'Envío';
        }

        // Inicializar y agregar event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar listeners para cambios en el método de envío
            document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
                radio.addEventListener('change', toggleShippingFields);
            });

            // Inicializar estado
            toggleShippingFields();
        });

        // Validación del formulario y procesamiento del pedido
        document.getElementById('checkout-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Alerta de confirmación antes de procesar el pedido
            const confirmResult = await Swal.fire({
                title: '¿Confirmar pedido?',
                text: '¿Estás seguro de que deseas confirmar tu pedido?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar'
            });
            if (!confirmResult.isConfirmed) {
                return;
            }
            
            try {
                // Validar stock
                const stockResponse = await fetch('{{ route("checkout.validate-stock") }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                });
                
                // Verificar si la respuesta es exitosa
                if (!stockResponse.ok) {
                    const errorText = await stockResponse.text();
                    console.error('Respuesta HTTP:', stockResponse.status, errorText);
                    throw new Error(`Error HTTP ${stockResponse.status}: ${stockResponse.statusText}`);
                }

                // Intentar parsear la respuesta como JSON
                const stockData = await stockResponse.json();
                
                if (!stockData.valid) {
                    let errorMessage = stockData.message || 'Error al validar el stock';
                    let errorDetails = '';
                    
                    if (stockData.error_type === 'insufficient_stock' && stockData.details) {
                        errorDetails = stockData.details.map(item => 
                            `${item.product_name}: Disponible ${item.available}, Solicitado ${item.requested}`
                        ).join('\n');
                    }

                    await Swal.fire({
                        icon: 'error',
                        title: 'Error de Stock',
                        text: errorMessage,
                        ...(errorDetails && {
                            html: `${errorMessage}<br><br><small class="text-gray-600">${errorDetails}</small>`,
                        }),
                        confirmButtonText: 'Entendido'
                    });
                    return;
                }

                // Procesar el pedido
                const formData = new FormData(this);
                const processResponse = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    credentials: 'same-origin'
                });

                // Verificar estado de la respuesta
                if (!processResponse.ok) {
                    const errorText = await processResponse.text();
                    console.error('Error en proceso:', errorText);
                    throw new Error(`Error HTTP ${processResponse.status}: ${processResponse.statusText}`);
                }

                const responseData = await processResponse.json();

                if (responseData.error) {
                    throw new Error(responseData.message || 'Error al procesar el pedido');
                }

                if (responseData.redirect) {
                    window.location.href = responseData.redirect;
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: responseData.message || 'Pedido procesado exitosamente',
                        confirmButtonText: 'Aceptar'
                    });
                }

            } catch (error) {
                console.error('Error detallado:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Ha ocurrido un error al procesar tu pedido. Por favor, intenta nuevamente.',
                    confirmButtonText: 'Entendido'
                });
            }
        });
    </script>
    @endpush
</x-app-layout>