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
            // Token brand dari design/styles.css — dipakai panel admin agar seragam
            // dengan situs publik. Halaman publik sendiri memakai styles.css apa adanya.
            fontFamily: {
                sans: ['Hanken Grotesk', 'Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Newsreader', ...defaultTheme.fontFamily.serif],
                mono: ['Space Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                ink: '#1b1a15',
                cream: '#f6f1e7',
                forest: '#20362a',
                'forest-2': '#28402f',
                leaf: '#5f7d48',
                amber: '#b9762b',
                gold: '#e8c79a',
                sand: '#efe7d6',
                muted: '#6b6455',
            },
        },
    },

    plugins: [forms],
};
