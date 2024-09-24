/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/views/**/*.php"
  ],
  darkMode: 'class', // Enable dark mode using a class
  theme: {
    extend: {
      colors: {
        'primary-green': '#52ff3f',
        'primary-dark-green': '#006400',
        'primary-blue': '#0033cc',
        'primary-dark-blue': '#001a66',
        'primary-blue2': '#bddbe8',
        'primary-dark-blue2': '#5a7c85',
        'primary-green2': '#99cc66',
        'primary-dark-green2': '#4d6633',
        'primary-white': '#FFFFFF',
        'primary-dark-white': '#bfbfbf',
        'primary-gray': '#E6F0DC',
        'primary-dark-gray': '#99a386',
        'primary': '#3B82F6',
        'secondary': '#10B981',
        'accent': '#8B5CF6',
    },
      fontFamily: {
        Ptsans: ['PT Sans', 'sans-serif'],
        PTserif: ['PT Serif', 'serif'],

      },
      keyframes: {
        glitch: {
          '0%': { transform: 'translate(0)' },
          '20%': { transform: 'translate(-2px, -2px)' },
          '40%': { transform: 'translate(2px, 2px)' },
          '60%': { transform: 'translate(-1px, 1px)' },
          '80%': { transform: 'translate(1px, -1px)' },
          '100%': { transform: 'translate(0)' },
        },
      },
      animation: {
        glitch: 'glitch 1s infinite',
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ]
}