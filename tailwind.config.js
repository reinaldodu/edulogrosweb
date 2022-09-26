const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    daisyui: {
        themes: ["light", "dark"],
      },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    //plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    // Se deshabilita tailwindcss/forms para evitar conflictos con Daisyu
    plugins: [require('@tailwindcss/typography'), require('daisyui')],
};
