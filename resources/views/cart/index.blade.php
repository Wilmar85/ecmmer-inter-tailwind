<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carrito de Compras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if ($cart->items->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">Tu carrito está vacío</p>
                            <a href="{{ route('products.index') }}" class="text-blue-500 hover:text-blue-700 font-semibold">
                                Continuar comprando
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Acciones</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cart->items as $item)
                                        @php
                                            // 1. Establecer una imagen de respaldo por defecto.
                                            $imageUrl = asset('storage/images/placeholder.jpg');

                                            // 2. Verificar si el producto tiene imágenes.
                                            if ($item->product->relationLoaded('images') && $item->product->images->isNotEmpty()) {
                                                // 3. Buscar la imagen principal o, en su defecto, la primera disponible.
                                                $image = $item->product->images->firstWhere('is_primary', true) ?? $item->product->images->first();
                                                
                                                if ($image && $path = $image->image_path) {
                                                    // 4. Construir la URL final de la imagen.
                                                    if (str_starts_with($path, 'http')) {
                                                        // Si ya es una URL completa (ej. de un CDN), se usa directamente.
                                                        $imageUrl = $path;
                                                    } elseif (str_starts_with($path, 'storage/')) {
                                                        // Si la ruta ya incluye 'storage/', se pasa directamente al helper asset().
                                                        $imageUrl = asset($path);
                                                    } else {
                                                        // Si es una ruta relativa, se le añade 'storage/' para que asset() la construya.
                                                        $imageUrl = asset('storage/' . ltrim($path, '/'));
                                                    }
                                                }
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @php
                                                        // Inicializar variables
                                                        $imageUrl = null;
                                                        $debugInfo = [];
                                                        
                                                        // Verificar si hay imágenes en el producto
                                                        if ($item->product->relationLoaded('images') && $item->product->images->isNotEmpty()) {
                                                            $primaryImage = $item->product->images->where('is_primary', true)->first() ?? $item->product->images->first();
                                                            
                                                            if ($primaryImage) {
                                                                $originalPath = $primaryImage->image_path; // Cambiado de 'path' a 'image_path'
                                                                $debugInfo['original_path'] = $originalPath;
                                                                
                                                                // Si es una URL completa, usarla directamente
                                                                if (str_starts_with($originalPath, 'http')) {
                                                                    $imageUrl = $originalPath;
                                                                    $debugInfo['type'] = 'full_url';
                                                                } 
                                                                // Si la ruta ya incluye 'storage/', usarla como está
                                                                elseif (str_starts_with($originalPath, 'storage/')) {
                                                                    $imageUrl = asset($originalPath);
                                                                    $debugInfo['type'] = 'storage_path';
                                                                } 
                                                                // Para rutas relativas, asumir que están en storage/app/public/images/products
                                                                else {
                                                                    // Eliminar cualquier barra inicial
                                                                    $cleanPath = ltrim($originalPath, '/');
                                                                    // Construir la ruta completa
                                                                    $imageUrl = asset('storage/' . $cleanPath);
                                                                    $debugInfo['type'] = 'relative_path';
                                                                    $debugInfo['clean_path'] = $cleanPath;
                                                                }
                                                                
                                                                $debugInfo['final_url'] = $imageUrl;
                                                                
                                                                // Verificar si el archivo existe
                                                                $storagePath = str_replace(url('/storage'), '', $imageUrl);
                                                                $storagePath = ltrim($storagePath, '/');
                                                                $fullPath = storage_path('app/public/' . $storagePath);
                                                                $debugInfo['file_exists'] = file_exists($fullPath) ? 'yes' : 'no';
                                                                $debugInfo['full_path'] = $fullPath;
                                                            } else {
                                                                $debugInfo['error'] = 'No primary image found';
                                                            }
                                                        } else {
                                                            $debugInfo['error'] = 'No images loaded for product';
                                                            $debugInfo['images_loaded'] = $item->product->relationLoaded('images') ? 'yes' : 'no';
                                                            $debugInfo['images_count'] = $item->product->images ? $item->product->images->count() : 0;
                                                        }
                                                    @endphp
                                                    
                                                    <div class="relative" style="min-height: 100px;">
                                                        @if($imageUrl)
                                                            <img src="{{ $imageUrl }}"
                                                                alt="{{ $item->product->name }}"
                                                                class="w-16 h-16 object-cover rounded border border-gray-200"
                                                                onerror="console.error('Error al cargar imagen:', this.src); this.onerror=null; this.src='{{ asset('storage/images/placeholder.jpg') }}';">
                                                        @else
                                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                                <span class="text-gray-500 text-xs">Sin imagen</span>
                                                            </div>
                                                        @endif
                                                        
                                                        <!-- Debug info (solo visible en entorno local) -->
                                                        @if(app()->environment('local'))
                                                            <div class="absolute -bottom-24 left-0 text-xs bg-white p-1 border border-gray-300 rounded z-10" style="width: 250px; max-height: 100px; overflow-y: auto;">
                                                                <div class="font-bold mb-1">Debug Info:</div>
                                                                @foreach($debugInfo as $key => $value)
                                                                    <div><span class="font-semibold">{{ $key }}:</span> {{ $value }}</div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <a href="{{ route('products.show', $item->product) }}"
                                                            class="text-sm font-medium text-gray-900 hover:text-blue-500">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        @if($item->product->sku)
                                                            <div class="text-xs text-gray-500">
                                                                {{ __('SKU') }}: {{ e($item->product->sku) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($item->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        min="1" max="{{ $item->product->stock }}"
                                                        class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                                                        Actualizar
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-500 uppercase">
                                            Total
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-lg font-bold text-gray-900">
                                            ${{ number_format($cart->total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-between items-center">
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md">
                                    Vaciar carrito
                                </button>
                            </form>

                            <a href="{{ route('checkout.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md">
                                Proceder al pago
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>