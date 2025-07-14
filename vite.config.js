// vite.config.js

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // <--- Importamos el módulo path

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            // Ignoramos las carpetas usando una ruta absoluta
            // Esto es más robusto y evita problemas de interpretación de rutas.
            ignored: [
                path.resolve(__dirname, 'storage/'),
                path.resolve(__dirname, 'public/'),
            ],
        },
    },
});