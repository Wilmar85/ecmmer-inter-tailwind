<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Productos') }}
            </h2>
            @if (Auth::user()?->isAdmin())
                <a href="{{ route('products.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Crear Producto') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                @if ($product->images->isNotEmpty())
    @php
        $imgUrl = method_exists($product->images->first(), 'getImageUrlAttribute') ? $product->images->first()->image_url : asset('storage/' . $product->images->first()->image_path);
    @endphp
    <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
@else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">Sin imagen</span>
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 100) }}
                                    </p>
                                    <p class="text-gray-800 font-bold mb-2">${{ number_format($product->price, 2) }}</p>
                                    <p class="text-sm text-gray-600 mb-4">Stock: {{ $product->stock }}</p>

                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="text-blue-500 hover:text-blue-700">
                                            Ver detalles
                                        </a>

                                        @if (Auth::user()?->isAdmin())
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                    class="text-yellow-500 hover:text-yellow-700">
                                                    Editar
                                                </a>

                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Botón flotante para subir al menú (solo home) -->
  <!-- Ajuste: scroll-to-top button y WhatsApp button no se solapan -->
  <div x-data="{ showBtn: false }" x-init="window.addEventListener('scroll', () => { showBtn = window.scrollY > 100 })" class="z-50">
    <div x-show="showBtn" style="display: none;" class="fixed right-6 bottom-[104px] sm:bottom-[104px] z-50">
      <button @click="window.scrollTo({top: 0, behavior: 'smooth'})" class="bg-blue-600 hover:bg-blue-800 text-white rounded-full shadow-lg flex items-center justify-center w-14 h-14 transition duration-200 focus:outline-none">
          <!-- Icono de flecha hacia arriba -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
          </svg>
      </button>
    </div>
    <script>
      document.addEventListener('alpine:init', () => {
        Alpine.store('scrollBtn', {
          visible: false
        });
      });
      document.addEventListener('scroll', () => {
        if(window.scrollY > 100) {
          Alpine.store('scrollBtn').visible = true;
        } else {
          Alpine.store('scrollBtn').visible = false;
        }
      });
    </script>
    <style>
      /* Ajuste para que el botón de WhatsApp y el de scroll no se solapen */
      #whatsapp-float {
        bottom: 28px !important;
        right: 24px !important;
        transition: right 0.3s cubic-bezier(.4,0,.2,1);
      }
      @media (max-width: 640px) {
        #whatsapp-float {
          bottom: 16px !important;
          right: 12px !important;
        }
      }
      #whatsapp-float.move-left {
        right: 104px !important;
      }
      @media (max-width: 640px) {
        #whatsapp-float.move-left {
          right: 80px !important;
        }
      }
    </style>
    <script>
      // Mover el botón de WhatsApp a la izquierda si el de subir está visible
      document.addEventListener('alpine:init', () => {
        Alpine.effect(() => {
          const btn = document.getElementById('whatsapp-float');
          if(btn) {
            if(Alpine.store('scrollBtn').visible) {
              btn.classList.add('move-left');
            } else {
              btn.classList.remove('move-left');
            }
          }
        });
      });
    </script>
  </div>
</x-app-layout>
