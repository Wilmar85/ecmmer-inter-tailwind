<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nuevo Ticket de Soporte') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <p class="font-bold">¡Error!</p>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="ticketForm" action="{{ route('support.tickets.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Asunto</label>
                            <input type="text" name="subject" id="subject" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">
                                Descripción
                                <span class="text-xs text-gray-500 font-normal">(mínimo 10 caracteres)</span>
                            </label>
                            <div class="mt-1 relative">
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="4" 
                                    required 
                                    minlength="10"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    oninput="updateCharCount(this)"
                                ></textarea>
                                <div class="flex justify-between">
                                    <p class="mt-1 text-xs text-gray-500">
                                        Describe tu problema o consulta con al menos 10 caracteres.
                                    </p>
                                    <span id="charCount" class="text-xs text-gray-500">0/10 caracteres</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Prioridad</label>
                            <select name="priority" id="priority" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="low">Baja</option>
                                <option value="medium" selected>Media</option>
                                <option value="high">Alta</option>
                                <option value="urgent">Urgente</option>
                            </select>
                        </div>

                        <div>
                            <label for="attachments" class="block text-sm font-medium text-gray-700">Archivos adjuntos</label>
                            <input type="file" name="attachments[]" id="file-upload" multiple
                                class="mt-1 block w-full text-sm text-gray-500
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-md file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-blue-50 file:text-blue-700
                                       hover:file:bg-blue-100"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
                            <p class="mt-1 text-xs text-gray-500">
                                Formatos permitidos: JPG, PNG, PDF, DOC, DOCX, TXT. Tamaño máximo: 10MB por archivo.
                            </p>
                        </div>
                        
                        <div class="flex justify-end space-x-4 pt-4">
                            <a href="{{ route('support.tickets.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                {{ __('Cancelar') }}
                            </a>
                            <button type="submit" id="submitButton"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('Enviar Ticket') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Función para actualizar el contador de caracteres
        function updateCharCount(textarea) {
            const charCount = textarea.value.length;
            const minLength = parseInt(textarea.getAttribute('minlength')) || 10;
            const charCountElement = document.getElementById('charCount');
            
            charCountElement.textContent = `${charCount}/${minLength} caracteres`;
            
            // Cambiar color según la longitud
            if (charCount < minLength) {
                charCountElement.classList.add('text-red-500');
                charCountElement.classList.remove('text-green-600');
            } else {
                charCountElement.classList.remove('text-red-500');
                charCountElement.classList.add('text-green-600');
            }
        }
        
        // Inicializar el contador al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const descriptionField = document.getElementById('description');
            if (descriptionField) {
                updateCharCount(descriptionField);
            }
        });
        // Depuración
        console.log('Página de creación de ticket cargada');
        console.log('Ruta del formulario:', '{{ route('support.tickets.store') }}');
        
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('ticketForm');
            const submitButton = document.getElementById('submitButton');
            
            if (!form) {
                console.error('No se encontró el formulario');
                return;
            }
            
            console.log('Formulario encontrado');
            
            // Mostrar nombre de archivos seleccionados
            const fileUpload = document.getElementById('file-upload');
            if (fileUpload) {
                fileUpload.addEventListener('change', function(e) {
                    const files = e.target.files;
                    const fileNames = Array.from(files).map(file => file.name);
                    console.log('Archivos seleccionados:', fileNames);
                });
            }
            
            // Validar antes de enviar
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                console.log('Validando formulario...');
                
                // Validar campos requeridos
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    field.style.borderColor = ''; // Resetear el borde
                    
                    // Validar campo vacío
                    if (!field.value.trim()) {
                        console.error(`Campo requerido vacío: ${field.name}`);
                        field.style.borderColor = 'red';
                        isValid = false;
                        return;
                    }
                    
                    // Validar longitud mínima para el campo de descripción
                    if (field.name === 'description' && field.value.trim().length < 10) {
                        console.error('La descripción debe tener al menos 10 caracteres');
                        field.style.borderColor = 'red';
                        isValid = false;
                        return;
                    }
                });
                
                if (!isValid) {
                    if (form.description.value.trim().length < 10) {
                        alert('La descripción debe tener al menos 10 caracteres');
                    } else {
                        alert('Por favor completa todos los campos requeridos');
                    }
                    return false;
                }
                
                // Deshabilitar el botón para evitar múltiples envíos
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Enviando...';
                }
                
                console.log('Formulario válido, enviando...');
                
                try {
                    const formData = new FormData(form);
                    
                    // Mostrar datos del formulario en consola
                    for (let [key, value] of formData.entries()) {
                        console.log(`${key}: ${value}`);
                    }
                    
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-XSRF-TOKEN': decodeURIComponent(document.cookie.replace(/(?:(?:^|.*;\s*)XSRF-TOKEN\s*\=\s*([^;]*).*$)|^.*$/, '$1'))
                        },
                        credentials: 'same-origin'
                    });
                    
                    const data = await response.json().catch(error => {
                        console.error('Error al parsear la respuesta JSON:', error);
                        throw new Error('Error al procesar la respuesta del servidor');
                    });
                    
                    console.log('Respuesta del servidor:', data);
                    
                    if (response.ok && data.success) {
                        // Mostrar mensaje de éxito
                        alert(data.message || '¡Ticket creado exitosamente!');
                        // Redirigir a la página de tickets o al ticket creado
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.href = '{{ route('support.tickets.index') }}';
                        }
                    } else {
                        // Mostrar errores de validación
                        if (response.status === 422 && data.errors) {
                            let errorMessage = 'Por favor corrige los siguientes errores:\n\n';
                            Object.values(data.errors).forEach(errors => {
                                errors.forEach(error => {
                                    errorMessage += `• ${error}\n`;
                                });
                            });
                            alert(errorMessage);
                        } else {
                            // Mostrar error general
                            console.error('Error en la respuesta del servidor:', data);
                            alert(data.message || 'Error al crear el ticket. Por favor, inténtalo de nuevo.');
                        }
                    }
                } catch (error) {
                    console.error('Error al enviar el formulario:', error);
                    alert('Error al conectar con el servidor. Por favor, verifica tu conexión e inténtalo de nuevo.');
                } finally {
                    // Re-habilitar el botón
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Enviar Ticket';
                    }
                }
                
                return false;
            });
        });
    </script>
    @endpush
</x-app-layout>
