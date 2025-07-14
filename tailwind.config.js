import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // AQUÍ REGISTRAMOS LOS COLORES
            colors: {
              'primary': '#fbbf24',      // Amarillo principal
              'secondary': '#1d3557',    // Azul oscuro del menú
              'dark-text': '#22223b',    // Texto oscuro para fondos claros
              'light-text': '#e2e8f0',   // Texto claro para fondos oscuros (gris claro)
            }
        },
    },

    plugins: [forms],
};