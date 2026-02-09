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
            colors: {
                primary: {
                    DEFAULT: '#131B31', // Zoopla Deep Navy
                    light: '#1E293B',
                    dark: '#0F172A',
                },
                secondary: {
                    DEFAULT: '#8046F1', // Zoopla Purple
                    light: '#A78BFA',
                    dark: '#6D28D9',
                },
                accent: {
                    DEFAULT: '#F4F4F5', // Zinc 100
                    dark: '#E4E4E7',
                    teal: '#00DEB6', // Rightmove Teal (unused if user dislikes)
                    red: '#EF4444',
                },
            },
            fontFamily: {
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            keyframes: {
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
            },
            animation: {
                fadeInUp: 'fadeInUp 0.8s ease-out forwards',
                fadeIn: 'fadeIn 1s ease-out forwards',
                float: 'float 3s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
