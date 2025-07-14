@php
    $metaTitle = $category->name . ' | E-commerce Web';
    $metaDescription = 'Encuentra los mejores productos en la categoría ' . $category->name;
    $metaKeywords = $category->name . ', productos, ecommerce, tienda';
    $ogTitle = $category->name;
    $ogDescription = 'Explora productos destacados de la categoría ' . $category->name;
    $ogImage = asset('images/default-og.png');
    $canonical = url()->current();
@endphp

@push('jsonld')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "{{ $category->name }}",
  "description": "Encuentra los mejores productos en la categoría {{ $category->name }}",
  "mainEntity": {
    "@type": "ItemList",
    "numberOfItems": {{ $products->count() }},
    "itemListElement": [
      @foreach($products as $index => $product)
        {
          "@type": "Product",
          "position": {{ $index + 1 }},
          "name": "{{ $product->name }}",
          "url": "{{ route('products.show', $product) }}"
        }@if(!$loop->last),@endif
      @endforeach
    ]
  }
}
</script>
@endpush

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                @if ($category->description)
                    <p class="mt-2 text-gray-600">{{ $category->description }}</p>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
    <x-product-card :product="$product" />
@empty
    <div class="col-span-full text-center text-gray-500">No hay productos en esta categoría.</div>
@endforelse
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
