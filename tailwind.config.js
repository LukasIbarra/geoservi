import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    ],

theme: {
    extend: {
        colors: {
            primary: '#F57C00',      // naranjo fuerte
            primaryDark: '#EF6C00',  // naranjo más oscuro
            
        },
        fontFamily: {
            sans: ['Roboto', 'sans-serif'],
        }
    }
},

    plugins: [forms],
};
