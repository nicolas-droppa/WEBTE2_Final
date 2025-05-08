/** @type {import('tailwindcss').Config} */
export default {
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