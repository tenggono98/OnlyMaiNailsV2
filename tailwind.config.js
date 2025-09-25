import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js",
        '!./resources/views/pdf/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'brand': {
                    'base-1': '#f6f7f1',
                    'base-2': '#f5f6f0', 
                    'base-3': '#f5f6f1',
                    'base-4': '#f8f8f3',
                    'base-5': '#faf9f5',
                    'base-6': '#f8f7f2',
                    'accent-light': '#efcabe',
                    'accent-medium': '#bcdabb',
                }
            },
        },
    },

    safelist: [
        '!duration-[0ms]',
        '!delay-[0ms]',
        'html.js :where([class*="taos:"]:not(.taos-init))'
      ],

    plugins: [forms,require('flowbite/plugin'),require('taos/plugin')],
};
