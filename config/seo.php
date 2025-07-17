<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración General de SEO
    |--------------------------------------------------------------------------
    */
    
    // Google Search Console verification code (solo el valor, no la etiqueta completa)
    'google_verification' => env('GOOGLE_SITE_VERIFICATION', null),
    
    // Google Analytics (UA-XXXXX-X o G-XXXXX)
    'google_analytics' => env('GOOGLE_ANALYTICS_ID', null),
    
    // Google Tag Manager
    'google_tag_manager' => env('GOOGLE_TAG_MANAGER_ID', null),
    
    // Meta tags por defecto
    'defaults' => [
        'title' => env('APP_NAME', 'InterEleticosf&A'),
        'description' => 'Tienda online de productos de calidad al mejor precio. ¡Descubre nuestras ofertas!',
        'keywords' => 'ecommerce, tienda, compras, ofertas, productos, categorías',
        'image' => '/images/default-og.png',
        'type' => 'website',
        'twitter_site' => '@tu_cuenta_twitter',
        'twitter_creator' => '@tu_cuenta_twitter',
    ],
    
    // Configuración de redes sociales
    'social' => [
        'twitter' => [
            'card' => 'summary_large_image',
            'site' => '@tu_cuenta_twitter',
            'creator' => '@tu_cuenta_twitter',
        ],
        'facebook' => [
            'app_id' => env('FACEBOOK_APP_ID'),
        ],
    ],
    
    // Estructura de datos para Schema.org
    'schema' => [
        'organization' => [
            'name' => env('APP_NAME', 'InterEleticosf&A'),
            'logo' => '/images/logo.png',
            'url' => env('APP_URL'),
            'sameAs' => [
                'https://www.facebook.com/tu_pagina',
                'https://twitter.com/tu_cuenta',
                'https://www.instagram.com/tu_cuenta',
                'https://www.linkedin.com/company/tu_empresa',
            ],
        ],
    ],
    
    // Sitemap configuration
    'sitemap' => [
        'enabled' => true,
        'cache' => 60, // minutos
        'models' => [
            // Ejemplo:
            // App\Models\Product::class => [
            //     'route' => 'products.show',
            //     'changefreq' => 'weekly',
            //     'priority' => '0.8',
            // ],
        ],
        'urls' => [
            // URLs estáticas
            ['url' => '/', 'changefreq' => 'daily', 'priority' => '1.0'],
            ['url' => '/shop', 'changefreq' => 'daily', 'priority' => '0.9'],
            ['url' => '/about', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => '/contact', 'changefreq' => 'monthly', 'priority' => '0.7'],
            ['url' => '/privacy', 'changefreq' => 'yearly', 'priority' => '0.3'],
            ['url' => '/terms', 'changefreq' => 'yearly', 'priority' => '0.3'],
        ],
    ],
];
