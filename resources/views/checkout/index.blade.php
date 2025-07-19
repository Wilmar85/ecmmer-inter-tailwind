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
                                        <select name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                            <option value="">Seleccione una ciudad</option>
                                            <option value="Bucaramanga" selected>Bucaramanga</option>
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
                                // Costo fijo de envío para todos los barrios
                                const FIXED_SHIPPING_COST = 5000; // Costo fijo de envío para todos los barrios

                                // Inicializar los selectores de ciudad y barrio
                                const citySelect = document.getElementById('city');
                                const neighborhoodSelect = document.getElementById('neighborhood');
                                
                                // Función para actualizar el costo de envío
                                function updateShippingCost() {
                                    try {
                                        const city = citySelect ? citySelect.value : 'Bucaramanga';
                                        const neighborhood = neighborhoodSelect ? neighborhoodSelect.value : '';
                                        
                                        // Actualizar el valor del input oculto del costo de envío
                                        const shippingInput = document.getElementById('shipping-cost-input');
                                        if (shippingInput) {
                                            shippingInput.value = FIXED_SHIPPING_COST;
                                        }
                                        
                                        // Actualizar el valor mostrado
                                        const shippingDisplay = document.getElementById('shipping-display');
                                        if (shippingDisplay) {
                                            shippingDisplay.textContent = formatCurrency(FIXED_SHIPPING_COST);
                                        }
                                        
                                        // Actualizar el total
                                        updateTotal();
                                    } catch (error) {
                                        console.error('Error al actualizar el costo de envío:', error);
                                    }
                                }

                                // Función para formatear moneda
                                function formatCurrency(amount) {
                                    return new Intl.NumberFormat('es-CO', {
                                        style: 'currency',
                                        currency: 'COP',
                                        minimumFractionDigits: 0
                                    }).format(amount);
                                }

                                // Función para cargar los barrios desde la API
                                async function loadNeighborhoods() {
                                    if (!neighborhoodSelect) return;
                                    
                                    try {
                                        // Mostrar indicador de carga
                                        neighborhoodSelect.innerHTML = '<option value="">Cargando barrios...</option>';
                                        neighborhoodSelect.disabled = true;
                                        
                                        console.log('Cargando barrios desde la API...');
                                        // Hacer la petición a la API
                                        const response = await fetch('/api/neighborhoods');
                                        const data = await response.json();
                                        
                                        console.log('Respuesta de la API:', data);
                                        
                                        if (data.success && data.data && data.data.neighborhoods) {
                                            // Limpiar el select
                                            neighborhoodSelect.innerHTML = '<option value="">Seleccione un barrio</option>';
                                            
                                            // Agregar los barrios al select
                                            data.data.neighborhoods.forEach(neighborhood => {
                                                const option = document.createElement('option');
                                                option.value = neighborhood;
                                                option.textContent = neighborhood;
                                                neighborhoodSelect.appendChild(option);
                                            });
                                            
                                            // Habilitar el select
                                            neighborhoodSelect.disabled = false;
                                            
                                            console.log('Barrios cargados correctamente');
                                            
                                            // Actualizar el costo de envío
                                            updateShippingCost();
                                        } else {
                                            throw new Error('No se pudieron cargar los barrios: ' + (data.message || 'Respuesta inesperada de la API'));
                                        }
                                    } catch (error) {
                                        console.error('Error al cargar los barrios:', error);
                                        neighborhoodSelect.innerHTML = `<option value="">Error al cargar los barrios: ${error.message}</option>`;
                                    }
                                }
                                
                                // Inicializar cuando el DOM esté listo
                                document.addEventListener('DOMContentLoaded', function() {
                                    console.log('DOM completamente cargado');
                                    
                                    // Verificar que los elementos existan
                                    if (!citySelect || !neighborhoodSelect) {
                                        console.error('No se encontraron los elementos del formulario');
                                        return;
                                    }
                                    
                                    // Establecer Bucaramanga como seleccionada por defecto
                                    citySelect.value = 'Bucaramanga';
                                    
                                    // Cargar los barrios
                                    loadNeighborhoods();
                                    
                                    // Actualizar el costo de envío cuando cambia el barrio
                                    neighborhoodSelect.addEventListener('change', updateShippingCost);
                                    
                                    console.log('Event listeners configurados correctamente');
                                });
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