@props(['slider' => null])

<div class="space-y-6">
    <!-- Título -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Título *</label>
        <input type="text" name="title" id="title" required
               value="{{ old('title', $slider->title ?? '') }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Descripción -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="description" id="description" rows="3"
                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">{{ old('description', $slider->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tipo de medio -->
    <div>
        <label class="block text-sm font-medium text-gray-700">Tipo de medio *</label>
        <div class="mt-1 grid grid-cols-2 gap-4">
            <label class="inline-flex items-center">
                <input type="radio" name="type" value="image" 
                       {{ (old('type', $slider->type ?? 'image') === 'image') ? 'checked' : '' }}
                       class="focus:ring-primary h-4 w-4 text-primary border-gray-300" onchange="toggleMediaType('image')">
                <span class="ml-2 text-sm text-gray-700">Imagen</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="type" value="video"
                       {{ (old('type', $slider->type ?? '') === 'video') ? 'checked' : '' }}
                       class="focus:ring-primary h-4 w-4 text-primary border-gray-300" onchange="toggleMediaType('video')">
                <span class="ml-2 text-sm text-gray-700">Video</span>
            </label>
        </div>
        @error('type')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Archivo multimedia -->
    <div id="media-upload">
        <label for="media" class="block text-sm font-medium text-gray-700">
            {{ (old('type', $slider->type ?? 'image') === 'image') ? 'Imagen' : 'Video' }} *
            @if(isset($slider) && $slider->media_path)
                <span class="text-xs font-normal text-gray-500">(Dejar en blanco para mantener el archivo actual)</span>
            @endif
        </label>
        <div class="mt-1 flex items-center">
            <input type="file" name="media" id="media" 
                   accept="{{ (old('type', $slider->type ?? 'image') === 'image') ? 'image/*' : 'video/*' }}" 
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
        </div>
        @error('media')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        
        @if(isset($slider) && $slider->media_path)
            <div class="mt-2 p-3 bg-yellow-50 rounded-md">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <div class="mt-2 flex items-center">
                        <input type="checkbox" name="remove_media" id="remove_media" value="1" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remove_media" class="ml-2 text-sm text-gray-700">Eliminar este archivo (debes subir uno nuevo)</label>
                    </div>
                    <p class="mt-1 text-xs text-yellow-700">Si marcas esta opción, asegúrate de subir un nuevo archivo antes de guardar.</p>
                </div>
            </div>
            
            <div class="mt-2">
                <p class="text-sm font-medium text-gray-700">Vista previa:</p>
                @if($slider->type === 'image')
                    <img src="{{ $slider->media_url }}" alt="{{ $slider->title }}" class="mt-1 h-40 w-auto rounded-md object-cover">
                @else
                    <video src="{{ $slider->media_url }}" controls class="mt-1 h-40 w-auto rounded-md bg-black"></video>
                @endif
            </div>
        @endif
    </div>

    <!-- Miniatura (opcional para videos) -->
    <div id="thumbnail-upload" class="{{ (old('type', $slider->type ?? 'image') === 'video') ? '' : 'hidden' }}">
        <label for="thumbnail" class="block text-sm font-medium text-gray-700">
            Miniatura (opcional)
            @if(isset($slider) && $slider->thumbnail_path)
                <span class="text-xs font-normal text-gray-500">(Dejar en blanco para mantener la miniatura actual)</span>
            @endif
        </label>
        <div class="mt-1 flex items-center">
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
        </div>
        @error('thumbnail')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        
        @if(isset($slider) && $slider->thumbnail_path)
            <div class="mt-2 flex items-center">
                <input type="checkbox" name="remove_thumbnail" id="remove_thumbnail" value="1" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                <label for="remove_thumbnail" class="ml-2 text-sm text-gray-700">Eliminar miniatura actual</label>
            </div>
            
            <div class="mt-2">
                <p class="text-sm font-medium text-gray-700">Miniatura actual:</p>
                <img src="{{ $slider->thumbnail_url }}" alt="Miniatura" class="mt-1 h-24 w-auto rounded-md object-cover">
            </div>
        @endif
    </div>

    <!-- Texto del botón -->
    <div>
        <label for="button_text" class="block text-sm font-medium text-gray-700">Texto del botón</label>
        <input type="text" name="button_text" id="button_text"
               value="{{ old('button_text', $slider->button_text ?? '') }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        @error('button_text')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- URL del botón -->
    <div>
        <label for="button_url" class="block text-sm font-medium text-gray-700">URL del botón</label>
        <input type="url" name="button_url" id="button_url"
               value="{{ old('button_url', $slider->button_url ?? '') }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
               placeholder="https://ejemplo.com">
        @error('button_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Orden -->
    <div class="w-32">
        <label for="sort_order" class="block text-sm font-medium text-gray-700">Orden</label>
        <input type="number" name="sort_order" id="sort_order" min="0"
               value="{{ old('sort_order', $slider->sort_order ?? 0) }}"
               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
        @error('sort_order')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Estado -->
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', isset($slider) ? $slider->is_active : true) ? 'checked' : '' }}
                   class="focus:ring-primary h-4 w-4 text-primary border-gray-300 rounded">
        </div>
        <div class="ml-3 text-sm">
            <label for="is_active" class="font-medium text-gray-700">Activo</label>
            <p class="text-gray-500">Mostrar este slider en el sitio web.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function toggleMediaType(type) {
        const mediaInput = document.getElementById('media');
        const thumbnailUpload = document.getElementById('thumbnail-upload');
        
        if (type === 'video') {
            mediaInput.setAttribute('accept', 'video/*');
            thumbnailUpload.classList.remove('hidden');
        } else {
            mediaInput.setAttribute('accept', 'image/*');
            thumbnailUpload.classList.add('hidden');
        }
        
        // Actualizar la etiqueta
        const mediaLabel = mediaInput.previousElementSibling;
        mediaLabel.textContent = (type === 'image' ? 'Imagen' : 'Video') + ' *';
    }
    
    // Inicializar el estado basado en el tipo seleccionado
    document.addEventListener('DOMContentLoaded', function() {
        const selectedType = document.querySelector('input[name="type"]:checked').value;
        toggleMediaType(selectedType);
    });
</script>
@endpush
