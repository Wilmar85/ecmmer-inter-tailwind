{{-- SEO Meta Tags Dinámicos y Estructurados --}}
<title>{{ $metaTitle ?? config('app.name', 'InterEleticosf&A') }}</title>
<meta name="description" content="{{ $metaDescription ?? 'Tienda online de productos de calidad al mejor precio. ¡Descubre nuestras ofertas!' }}">
<meta name="keywords" content="{{ $metaKeywords ?? 'ecommerce, tienda, compras, ofertas, productos, categorías' }}">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ $canonical ?? url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:title" content="{{ $ogTitle ?? $metaTitle ?? config('app.name', 'E-commerce Web') }}">
<meta property="og:description" content="{{ $ogDescription ?? $metaDescription ?? '' }}">
<meta property="og:image" content="{{ $ogImage ?? asset('images/default-og.png') }}">
<meta property="og:url" content="{{ $canonical ?? url()->current() }}">
<meta property="og:type" content="website">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $twitterTitle ?? $metaTitle ?? config('app.name', 'E-commerce Web') }}">
<meta name="twitter:description" content="{{ $twitterDescription ?? $metaDescription ?? '' }}">
<meta name="twitter:image" content="{{ $twitterImage ?? asset('images/default-og.png') }}">

{{-- Google Search Console Verification (opcional) --}}
@if(config('seo.google_verification'))
    <meta name="google-site-verification" content="{{ config('seo.google_verification') }}" />
@endif

{{-- Structured Data JSON-LD (opcional, se puede sobrescribir en cada vista) --}}
@stack('jsonld')
