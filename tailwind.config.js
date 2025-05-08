import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
<<<<<<< HEAD
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
        },
    },

    plugins: [forms],
};
=======
  darkMode: 'class',
  content: [
      './resources/views/**/*.blade.php',  // Toto pokrýva všetky blade súbory v priečinku views
      './resources/js/**/*.js',            // Pre JS súbory (ak sa používajú)
  ],
  theme: {
      extend: {},
  },
  plugins: [],
}
>>>>>>> darktheme
