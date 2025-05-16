/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  safelist: [
    'border-green-500', 'border-red-500', 'border-yellow-500', 'border-blue-500',
    'bg-green-500/20', 'bg-red-500/20', 'bg-yellow-500/20', 'bg-blue-500/20',
    'dark:bg-green-900/30', 'dark:bg-red-900/30',
    'dark:bg-yellow-900/30','dark:bg-blue-900/30',
    'text-green-800', 'text-red-800', 'text-yellow-800', 'text-blue-800',
    'dark:text-green-200','dark:text-red-200','dark:text-yellow-200','dark:text-blue-200',
    'hover:text-green-600','hover:text-red-600',
    'hover:text-yellow-600','hover:text-blue-600',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}