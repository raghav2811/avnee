import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'top-bar': '#4B0082',
                'top-bar-text': '#A47DAB',
                'top-bar-dark': '#300E54',
                'brand-gold': '#F8C8DC',
                'header-bg': '#4B0082',
                'icon-dark': '#A47DAB',
                'nav-bg': '#4B0082',
                'mulberry': '#770737',
                'pastel-pink': '#F8C8DC',
                'header-surface': '#FFF0F5',
                'jw-primary': '#f3d9ff',
                'jw-tertiary': '#d4af37',
                'jw-surface': '#2B003A',
                'jw-card': '#350047',
                'jw-border': '#4f006a',
                'jw-muted': '#e9d5ff',
                'jw-container': '#3b0050',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                heading: ['"Cormorant Garamond"', '"Noto Serif"', 'Georgia', 'serif'],
                body: ['"DM Sans"', '"Manrope"', 'sans-serif'],
                logo: ['"Cinzel"', '"Bodoni Moda"', '"Noto Serif"', 'serif'],
            },
        },
    },

    plugins: [forms],
};
