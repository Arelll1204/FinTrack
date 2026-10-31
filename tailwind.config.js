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
                sans: ['"Plus Jakarta Sans"', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'nav-bg': '#0D1526',
                'page-bg': '#0B1220',
                'surface': '#111A2B',
                'surface-hover': '#16233B',
                'surface-card': '#111A2B',
                'border': '#1E2A3F',
                'border-light': '#2A3B56',
                'primary': '#E6EDF7',
                'secondary': '#8A97AD',
                'text-primary': '#E6EDF7',
                'text-secondary': '#8A97AD',
                'accent': '#2DD4BF',
                'income': '#34D399',
                'expense': '#F87171',
                'budget-warn': '#FBBF24',
            },
            borderRadius: {
                lg: '10px',
                md: '8px',
            },
        }
    },

    plugins: [forms],
};
