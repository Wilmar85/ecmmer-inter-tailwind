{{-- SEO Meta Tags Dinámicos y Estructurados --}}
<title>{{ $metaTitle ?? config('app.name', 'InterEleticosf&A') }}</title>
<meta name="description" content="{{ $metaDescription ?? 'Tienda online de productos de calidad al mejor precio. ¡Descubre nuestras ofertas!' }}">
<meta name="keywords" content="{{ $metaKeywords ?? 'ecommerce, tienda, compras, ofertas, productos, categorías' }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $canonical ?? url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:locale" content="{{ app()->getLocale() }}">
<meta property="og:title" content="{{ $ogTitle ?? $metaTitle ?? config('app.name', 'InterEleticosf&A') }}">
<meta property="og:description" content="{{ $ogDescription ?? $metaDescription ?? 'Tienda online de productos de calidad al mejor precio' }}">
<meta property="og:image" content="{{ $ogImage ?? asset('images/default-og.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ $canonical ?? url()->current() }}">
<meta property="og:type" content="website">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@tu_cuenta_twitter">
<meta name="twitter:creator" content="@tu_cuenta_twitter">
<meta name="twitter:title" content="{{ $twitterTitle ?? $metaTitle ?? config('app.name', 'InterEleticosf&A') }}">
<meta name="twitter:description" content="{{ $twitterDescription ?? $metaDescription ?? 'Tienda online de productos de calidad al mejor precio' }}">
<meta name="twitter:image" content="{{ $twitterImage ?? asset('images/default-og.png') }}">

<!-- Schema.org para Google -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "{{ config('app.name') }}",
    "url": "{{ url('/') }}",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "{{ url('/search') }}?q={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>

{{-- Google Search Console Verification --}}
@if(config('seo.google_verification'))
    <meta name="google-site-verification" content="{{ config('seo.google_verification') }}" />
@endif

{{-- Structured Data JSON-LD (se puede sobrescribir en cada vista) --}}
@stack('jsonld')
