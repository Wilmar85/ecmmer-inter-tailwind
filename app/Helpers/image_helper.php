<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('optimized_image')) {
    /**
     * Genera el HTML para mostrar una imagen optimizada con soporte para diferentes tamaños y lazy loading.
     *
     * @param string $path Ruta relativa de la imagen (ej: 'images/products/example.jpg')
     * @param string $size Tamaño de la imagen a mostrar (ej: 'thumb', 'medium', 'original')
     * @param string $alt Texto alternativo para la imagen
     * @param array $attributes Atributos HTML adicionales para la etiqueta img
     * @return string
     */
    function optimized_image($path, $size = 'original', $alt = '', $attributes = [])
    {
        // Limpiar y normalizar la ruta
        $path = ltrim($path, '/');
        
        // Si la ruta es una URL completa, devolverla tal cual
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return '<img src="' . $path . '" alt="' . e($alt) . '" ' . 
                   'loading="lazy" ' . 
                   implode(' ', array_map(function($key, $value) {
                       return $key . '="' . e($value) . '"';
                   }, array_keys($attributes), $attributes)) . '>';
        }
        
        // Construir rutas
        $basePath = 'storage/' . dirname($path);
        $fileName = basename($path);
        
        // Si no es 'original', buscar en el directorio de tamaño correspondiente
        if ($size !== 'original') {
            $sizedPath = $basePath . '/' . $size . '/' . $fileName;
            $fullPath = public_path($sizedPath);
            
            // Si existe la versión en el tamaño solicitado, usarla
            if (file_exists($fullPath)) {
                $src = asset($sizedPath);
            } else {
                // Si no existe, usar la versión original
                $src = asset($basePath . '/' . $fileName);
            }
        } else {
            $src = asset($basePath . '/' . $fileName);
        }
        
        // Construir atributos HTML
        $attrs = [
            'src' => $src,
            'alt' => e($alt),
            'loading' => 'lazy',
            'decoding' => 'async',
            'class' => $attributes['class'] ?? ''
        ];
        
        // Agregar atributos adicionales
        foreach ($attributes as $key => $value) {
            if (!in_array($key, ['class', 'src', 'alt', 'loading', 'decoding'])) {
                $attrs[$key] = $value;
            }
        }
        
        // Construir la etiqueta img
        $html = '<img';
        foreach ($attrs as $key => $value) {
            if (!empty($value) || $value === '0') {
                $html .= ' ' . $key . '="' . e($value) . '"';
            }
        }
        $html .= '>';
        
        return $html;
    }
}

if (!function_exists('picture_element')) {
    /**
     * Genera un elemento <picture> con fuentes para diferentes tamaños y formatos.
     *
     * @param string $path Ruta base de la imagen
     * @param array $sources Array de fuentes con formatos y tamaños
     * @param string $alt Texto alternativo
     * @param array $attributes Atributos para la etiqueta img
     * @return string
     */
    function picture_element($path, $sources, $alt = '', $attributes = [])
    {
        $html = '<picture>';
        
        // Agregar fuentes
        foreach ($sources as $source) {
            $srcset = [];
            
            // Construir srcset para cada tamaño
            foreach (($source['sizes'] ?? ['1x']) as $size => $width) {
                $src = str_replace('{size}', $width, $path);
                $srcset[] = asset($src) . ' ' . $size;
            }
            
            $html .= '<source ';
            $html .= 'srcset="' . implode(', ', $srcset) . '" ';
            
            if (isset($source['type'])) {
                $html .= 'type="' . $source['type'] . '" ';
            }
            
            if (isset($source['media'])) {
                $html .= 'media="' . $source['media'] . '" ';
            }
            
            $html .= '>';
        }
        
        // Imagen por defecto (última fuente o la original)
        $defaultSrc = asset($path);
        $html .= '<img src="' . $defaultSrc . '" alt="' . e($alt) . '" ';
        
        // Agregar atributos
        foreach ($attributes as $key => $value) {
            if ($key !== 'src' && $key !== 'alt') {
                $html .= $key . '="' . e($value) . '" ';
            }
        }
        
        $html .= 'loading="lazy" decoding="async">';
        $html .= '</picture>';
        
        return $html;
    }
}
