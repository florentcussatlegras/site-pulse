
/** @type {import('tailwindcss').Config} */
const config = {
  content: [
    './templates/**/*.html.twig',       // tous les templates Twig
    './assets/react/**/*.{js,ts,jsx,tsx}', // tous les fichiers React/TSX
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui'],
      }
    },
  },
  darkMode: "class",
  plugins: [
    // require('@tailwindcss/forms'),
    // require('@tailwindcss/typography'),
  ],
}

module.exports = config;
