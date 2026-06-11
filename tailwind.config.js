import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                cedar: {
                    50: '#fbf6f1',
                    100: '#f5ebdf',
                    200: '#e9d4bf',
                    300: '#dbb696',
                    400: '#cc926b',
                    500: '#c1784e',
                    600: '#b36443',
                    700: '#955039',
                    800: '#794133',
                    900: '#62372c',
                    950: '#3c1f19',
                },
                emerald: {
                    50: '#fbf6f1',
                    100: '#f5ebdf',
                    200: '#e9d4bf',
                    300: '#dbb696',
                    400: '#cc926b',
                    500: '#c1784e',
                    600: '#b36443',
                    650: '#955039',
                    700: '#955039',
                    800: '#794133',
                    900: '#62372c',
                    950: '#3c1f19',
                },
                green: {
                    50: '#fbf6f1',
                    100: '#f5ebdf',
                    200: '#e9d4bf',
                    300: '#dbb696',
                    400: '#cc926b',
                    500: '#c1784e',
                    600: '#b36443',
                    650: '#955039',
                    700: '#955039',
                    800: '#794133',
                    900: '#62372c',
                    950: '#3c1f19',
                }
            },
        },
    },

    plugins: [forms],
};
