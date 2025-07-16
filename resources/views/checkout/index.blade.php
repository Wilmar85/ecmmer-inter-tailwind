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
                                // Costos de envío por barrio
                                const shippingCosts = {
                                    'Bogotá': {
                                        'Chapinero': 5000,
                                        'Usaquén': 6000,
                                        'Teusaquillo': 5500,
                                        'Suba': 7000,
                                        'Fontibón': 8000,
                                        'Kennedy': 9000,
                                        'Engativá': 7500,
                                        'Barrios Unidos': 6000,
                                        'Puente Aranda': 7000,
                                        'Antonio Nariño': 6500,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Medellín': {
                                        'El Poblado': 5000,
                                        'Laureles': 6000,
                                        'Belen': 5500,
                                        'Castilla': 7000,
                                        'Robledo': 8000,
                                        'Manrique': 7500,
                                        'Aranjuez': 6000,
                                        'Buenos Aires': 7000,
                                        'San Javier': 6500,
                                        'La América': 5500,
                                        'La Candelaria': 5000,
                                        'Doce de Octubre': 6000,
                                        'Guayabal': 7000,
                                        'San Antonio de Prado': 7500,
                                        'Santa Cruz': 8000,
                                        'Popular': 6500,
                                        'Villa Hermosa': 6000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Cali': {
                                        'San Fernando': 5000,
                                        'Granada': 6000,
                                        'El Peñón': 5500,
                                        'Aguablanca': 7000,
                                        'Ciudad Jardín': 8000,
                                        'San Antonio': 7500,
                                        'La Flora': 6000,
                                        'Versalles': 7000,
                                        'El Ingenio': 6500,
                                        'Santa Mónica': 5500,
                                        'La Merced': 5000,
                                        'Alfonso López': 6000,
                                        'Siloé': 7000,
                                        'Meléndez': 7500,
                                        'San Nicolás': 8000,
                                        'Sucre': 6500,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Barranquilla': {
                                        'El Prado': 5000,
                                        'Alto Prado': 6000,
                                        'Villa Country': 5500,
                                        'Ciudad Jardín': 7000,
                                        'Boston': 8000,
                                        'La Concepción': 7500,
                                        'Las Delicias': 6000,
                                        'San Vicente': 7000,
                                        'Rebolo': 6500,
                                        'La Unión': 5500,
                                        'Las Nieves': 5000,
                                        'Montecristo': 6000,
                                        'La Ceiba': 7000,
                                        'El Recreo': 7500,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Cartagena': {
                                        'Getsemaní': 5000,
                                        'Bocagrande': 6000,
                                        'Manga': 5500,
                                        'El Cabrero': 7000,
                                        'La Matuna': 8000,
                                        'Pie de la Popa': 7500,
                                        'Crespo': 6000,
                                        'Chambacú': 7000,
                                        'San Diego': 6500,
                                        'Torices': 5500,
                                        'La Boquilla': 5000,
                                        'El Bosque': 6000,
                                        'Olaya Herrera': 7000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Bucaramanga': {
                                        'Cabecera': 5000,
                                        'Alarcón': 6000,
                                        'Antonia Santos': 5500,
                                        'Provenza': 7000,
                                        'La Concordia': 8000,
                                        'Mutis': 7500,
                                        'San Alonso': 6000,
                                        'San Francisco': 7000,
                                        'La Universidad': 6500,
                                        'Sotomayor': 5500,
                                        'Girardot': 5000,
                                        'La Feria': 6000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Pereira': {
                                        'Cuba': 5000,
                                        'Alamos': 6000,
                                        'Centro': 5500,
                                        'Boston': 7000,
                                        'San Joaquín': 8000,
                                        'Villavicencio': 7500,
                                        'El Jardín': 6000,
                                        'San Nicolás': 7000,
                                        'La Circunvalar': 6500,
                                        'Villa Santana': 5500,
                                        'Kennedy': 5000,
                                        'San Fernando': 6000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Manizales': {
                                        'Palogrande': 5000,
                                        'La Enea': 6000,
                                        'Chipre': 5500,
                                        'El Cable': 7000,
                                        'San Jorge': 8000,
                                        'La Francia': 7500,
                                        'Centro': 6000,
                                        'Malhabar': 7000,
                                        'Los Rosales': 6500,
                                        'Villa Pilar': 5500,
                                        'Campohermoso': 5000,
                                        'Villahermosa': 6000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Cúcuta': {
                                        'La Playa': 5000,
                                        'Ciudad Jardín': 6000,
                                        'La Cabrera': 5500,
                                        'Quinta Oriental': 7000,
                                        'Aeropuerto': 8000,
                                        'El Rodeo': 7500,
                                        'La Victoria': 6000,
                                        'San José de Cúcuta': 7000,
                                        'Colsag': 6500,
                                        'Avenida 6': 5500,
                                        'La Libertad': 5000,
                                        'Los Patios': 6000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'Ibagué': {
                                        'Centro': 5000,
                                        'La Pola': 6000,
                                        'La Francia': 5500,
                                        'El Salado': 7000,
                                        'El Salado Popular': 8000,
                                        'San Simón': 7500,
                                        'El Bosque': 6000,
                                        'El Jardín': 7000,
                                        'San Fernando': 6500,
                                        'El Líbano': 5500,
                                        'El Vergel': 5000,
                                        'Picaleña': 6000,
                                        'default': 8000 // Costo por defecto para otros barrios
                                    },
                                    'default': 10000 // Costo por defecto para otras ciudades
                                };

                                // Obtener el costo de envío basado en la ciudad y el barrio
                                function getShippingCost(city, neighborhood) {
                                    if (shippingCosts[city] && shippingCosts[city][neighborhood]) {
                                        return shippingCosts[city][neighborhood];
                                    } else if (shippingCosts[city] && shippingCosts[city]['default']) {
                                        return shippingCosts[city]['default'];
                                    } else {
                                        return shippingCosts['default'];
                                    }
                                }

                                // Actualizar el costo de envío cuando cambia el barrio
                                function updateShippingCost() {
                                    try {
                                        const city = document.getElementById('city').value;
                                        const neighborhood = document.getElementById('neighborhood').value;
                                        const deliveryChecked = document.getElementById('delivery').checked;
                                        
                                        if (deliveryChecked) {
                                            const shippingCost = getShippingCost(city, neighborhood);
                                            console.log('Actualizando costo de envío a:', shippingCost);
                                            
                                            // Actualizar el valor en el input oculto
                                            const shippingInput = document.getElementById('shipping-cost-input');
                                            if (shippingInput) {
                                                shippingInput.value = shippingCost;
                                            }
                                            
                                            // Actualizar el valor mostrado
                                            const shippingDisplay = document.getElementById('shipping-cost');
                                            if (shippingDisplay) {
                                                shippingDisplay.textContent = formatCurrency(shippingCost);
                                            }
                                            
                                            // Actualizar el total
                                            updateTotal();
                                        }
                                    } catch (error) {
                                        console.error('Error al actualizar el costo de envío:', error);
                                    }
                                }

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
                                        'La Playa', 'Ciudad Jardín', 'La Cabrera', 'Quinta Oriental', 'Aeropuerto', 'El Rodeo', 'La Victoria', 'San José de Cúcuta', 'Colsag', 'Avenida 6', 'La Libertad', 'Los Patios'
                                    ],
                                    'Ibagué': [
                                        'Centro', 'La Pola', 'La Francia', 'El Salado', 'El Salado Popular', 'San Simón', 'El Bosque', 'El Jardín', 'San Fernando', 'El Líbano', 'El Vergel', 'Picaleña'
                                    ]
                                };

                                // Inicializar los selectores de ciudad y barrio
                                const citySelect = document.getElementById('city');
                                const neighborhoodSelect = document.getElementById('neighborhood');
                                
                                if (citySelect && neighborhoodSelect) {
                                    // Función para actualizar los barrios basados en la ciudad seleccionada
                                    function updateNeighborhoods() {
                                        const selectedCity = citySelect.value;
                                        
                                        // Limpiar opciones actuales
                                        neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';
                                        
                                        // Agregar opciones de barrios para la ciudad seleccionada
                                        if (selectedCity && neighborhoodsByCity[selectedCity]) {
                                            neighborhoodsByCity[selectedCity].forEach(function(neighborhood) {
                                                const option = document.createElement('option');
                                                option.value = neighborhood;
                                                option.textContent = neighborhood;
                                                neighborhoodSelect.appendChild(option);
                                            });
                                        }
                                        
                                        // Habilitar o deshabilitar el select de barrios
                                        neighborhoodSelect.disabled = !selectedCity;
                                        
                                        // Actualizar el costo de envío cuando cambia la ciudad
                                        updateShippingCost();
                                    }
                                    
                                    // Actualizar barrios cuando cambia la ciudad
                                    citySelect.addEventListener('change', updateNeighborhoods);
                                    
                                    // Actualizar costo de envío cuando cambia el barrio
                                    neighborhoodSelect.addEventListener('change', updateShippingCost);
                                    
                                    // Inicializar barrios al cargar la página
                                    updateNeighborhoods();
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
                        <h3 class="text-xl font-bold text-dark-text mb-4 border-b pb-2">Resumen del Pedido</h3>
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between items-center py-2 border-b">
                                <div>
                                    <p class="text-sm font-medium text-dark-text">{{ $item->product->name }}</p>
                                    <p class="text-xs text-light-text">Cantidad: {{ $item->quantity }}</p>
                                </div>
                                <span class="text-sm font-medium text-dark-text">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                            @endforeach

                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-sm text-light-text">Subtotal</span>
                                    <span class="font-medium text-dark-text">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-sm text-light-text">IVA (19%)</span>
                                    <span class="font-medium text-dark-text">${{ number_format($subtotal * 0.19, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Envío</span>
                                    <div class="flex items-center">
                                        <input type="hidden" name="shipping_cost" id="shipping-cost-input" value="{{ $shipping }}">
                                        <span id="shipping-cost" class="font-medium mr-2">${{ number_format($shipping, 2) }}</span>
                                        <button type="button" id="edit-shipping-btn" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-dark-text" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="shipping-edit-container" class="hidden mt-2">
                                    <div class="flex items-center">
                                        <input type="number" id="manual-shipping-input" class="w-24 px-2 py-1 border border-gray-300 rounded-md text-sm" min="0" step="100">
                                        <button type="button" id="save-shipping-btn" class="ml-2 px-2 py-1 bg-primary text-dark-text text-sm rounded-md hover:bg-primary/90">
                                            Guardar
                                        </button>
                                        <button type="button" id="cancel-shipping-edit" class="ml-2 px-2 py-1 bg-gray-200 text-dark-text text-sm rounded-md hover:bg-gray-300">
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-between text-base font-medium">
                                    <span class="text-base font-semibold text-dark-text">Total</span>
                                    <span id="total-amount" class="text-base font-semibold text-dark-text">${{ number_format($total, 2) }}</span>
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
            try {
                const shippingMethodRadio = document.querySelector('input[name="shipping_method"]:checked');
                if (!shippingMethodRadio) return;
                
                const shippingMethod = shippingMethodRadio.value;
                const shippingAddressSection = document.getElementById('shipping-address-section');
                const shippingLabel = document.getElementById('shipping-label');
                const shippingCostInput = document.getElementById('shipping-cost-input');
                
                if (shippingMethod === 'pickup') {
                    // Ocultar campos de dirección y establecer costo de envío a 0
                    if (shippingAddressSection) shippingAddressSection.style.display = 'none';
                    if (shippingLabel) shippingLabel.textContent = 'Envío (Retiro en Tienda)';
                    if (shippingCostInput) shippingCostInput.value = '0';
                } else {
                    // Mostrar campos de dirección y actualizar costo según ciudad/barrio
                    if (shippingAddressSection) shippingAddressSection.style.display = 'block';
                    if (shippingLabel) shippingLabel.textContent = 'Envío';
                    updateShippingCost();
                }
                
                updateTotal();
            } catch (error) {
                console.error('Error en toggleShippingFields:', error);
            }
        }

        // Función para actualizar el total
        function updateTotal() {
            try {
                // Obtener el subtotal del carrito y asegurarse de que sea un número
                const subtotal = Number({{ $subtotal }});
                if (isNaN(subtotal)) {
                    throw new Error('Subtotal no es un número válido');
                }
                
                // Obtener el método de envío seleccionado
                const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
                const isPickup = shippingMethod && shippingMethod.value === 'pickup';
                
                // Calcular el IVA (19% del subtotal)
                const tax = subtotal * 0.19;
                
                // Obtener el costo de envío (0 si es retiro en tienda)
                let shipping = 0;
                if (!isPickup) {
                    const shippingInput = document.getElementById('shipping-cost-input');
                    // Convertir a número y manejar valores no numéricos
                    shipping = shippingInput ? parseFloat(shippingInput.value) || 0 : 0;
                }
                
                // Calcular el total (subtotal + IVA + envío si aplica)
                const total = subtotal + tax + shipping;
                
                // Función segura para actualizar el contenido de un elemento
                function safeUpdateElement(id, value) {
                    const element = document.getElementById(id);
                    if (element) {
                        element.textContent = value;
                    }
                }
                
                // Actualizar los valores en la interfaz de manera segura
                safeUpdateElement('subtotal-amount', formatCurrency(subtotal));
                safeUpdateElement('tax-amount', formatCurrency(tax));
                safeUpdateElement('shipping-cost', isPickup ? '$0' : formatCurrency(shipping));
                safeUpdateElement('total-amount', formatCurrency(total));
                
                // Actualizar el valor oculto del formulario
                const shippingInput = document.getElementById('shipping-cost-input');
                if (shippingInput) {
                    shippingInput.value = isPickup ? '0' : shipping.toString();
                }
                
                // Actualizar el input manual si está visible
                const manualInput = document.getElementById('manual-shipping-input');
                if (manualInput && !manualInput.hidden) {
                    manualInput.value = isPickup ? '0' : shipping.toString();
                }
                
                return true;
                
            } catch (error) {
                console.error('Error en updateTotal:', error);
                return false;
            }
        }

        // Función para formatear el valor numérico como moneda
        function formatCurrency(value) {
            return '$' + parseFloat(value || 0).toLocaleString('es-CO');
        }

        // Función para manejar la edición manual del costo de envío
        function setupShippingEdit() {
            const editBtn = document.getElementById('edit-shipping-btn');
            const shippingCost = document.getElementById('shipping-cost');
            const shippingInput = document.getElementById('shipping-cost-input');
            const editContainer = document.getElementById('shipping-edit-container');
            const manualInput = document.getElementById('manual-shipping-input');
            const saveBtn = document.getElementById('save-shipping-btn');
            const cancelBtn = document.getElementById('cancel-shipping-edit');

            if (!editBtn) return;

            // Mostrar el formulario de edición
            editBtn.addEventListener('click', function() {
                const currentValue = shippingInput.value || '0';
                manualInput.value = currentValue;
                editContainer.classList.remove('hidden');
                manualInput.focus();
            });

            // Guardar el valor manual
            function saveManualShipping() {
                const newValue = parseFloat(manualInput.value) || 0;
                shippingInput.value = newValue;
                shippingCost.textContent = formatCurrency(newValue);
                editContainer.classList.add('hidden');
                updateTotal();
            }

            // Manejar clic en guardar
            saveBtn.addEventListener('click', saveManualShipping);

            // Manejar la tecla Enter en el input
            manualInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    saveManualShipping();
                }
            });

            // Cancelar la edición
            cancelBtn.addEventListener('click', function() {
                editContainer.classList.add('hidden');
            });
        }

        // Inicializar y agregar event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar la edición manual del costo de envío
            setupShippingEdit();
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
            
            // Asegurarse de que el valor del envío esté actualizado
            updateTotal();
            
            // Verificar que el valor del envío sea un número válido
            const shippingInput = document.getElementById('shipping-cost-input');
            const shippingValue = parseFloat(shippingInput ? shippingInput.value : 0) || 0;
            
            // Actualizar el valor en el formulario
            if (shippingInput) {
                shippingInput.value = shippingValue.toString();
            }

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