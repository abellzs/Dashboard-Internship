import defaultTheme from 'tailwindcss/defaultTheme'
import plugin from 'tailwindcss/plugin'
// import preset from './vendor/filament/filament/tailwind.config.preset'

export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './resources/views/livewire/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './app/Filament/**/*.php',
  ],
  theme: {
    container: {
      center: true,
      padding: '1rem',
      screens: {
        lg: '1124px',
        xl: '1124px',
        '2xl': '1124px',
      },
    },
    extend: {
      fontFamily: {
        sans: ['Poppins', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        primary: '#ED1E28',
        secondary: '#F1F1F1',
        dark: '#333333',
        light: '#fafafa',
        neutral: {
          100: '#f5f5f5',
          200: '#e5e5e5',
          300: '#d4d4d4',
          400: '#a3a3a3',
          500: '#737373',
          600: '#525252',
          700: '#404040',
          800: '#262626',
          900: '#171717',
        },
      },
      borderRadius: {
        xl: '1rem',
      },
      boxShadow: {
        card: '0 4px 12px rgba(0, 0, 0, 0.08)',
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in forwards',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: 0 },
          '100%': { opacity: 1 },
        },
      },
    },
  },
  plugins: [
    plugin(function ({ addVariant }) {
      addVariant('child', '& > *')
      addVariant('child-hover', '& > *:hover')
    }),

    // 🔹 Tambah plugin custom button
    plugin(function ({ addComponents }) {
      addComponents({
        '.btn-primary': {
          '@apply px-6 py-2 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed disabled:hover:bg-gray-400': {},
        },
        '.btn-secondary': {
          '@apply px-6 py-2 rounded-lg font-semibold text-gray-800 bg-gray-300 hover:bg-gray-400 transition duration-200 disabled:bg-gray-300 disabled:opacity-60 disabled:cursor-not-allowed': {},
        },
        '.btn-success': {
          '@apply px-6 py-2 rounded-lg font-semibold text-white bg-green-600 hover:bg-green-700 transition duration-200 disabled:bg-gray-400 disabled:cursor-not-allowed': {},
        },
      })
    }),
  ],

  safelist: [
    'bg-gray-600', 'text-white', 'border-gray-600', 'hover:bg-gray-50', 'hover:border-gray-400',
    'bg-blue-600', 'text-white', 'border-blue-600', 'hover:bg-blue-50', 'hover:border-blue-400',
    'bg-green-600', 'text-white', 'border-green-600', 'hover:bg-green-50', 'hover:border-green-400',
    'bg-red-600', 'text-white', 'border-red-600', 'hover:bg-red-50', 'hover:border-red-400',
    'bg-yellow-600', 'text-white', 'border-yellow-600', 'hover:bg-yellow-50', 'hover:border-yellow-400',
    'shadow-md', 'scale-105',
  ],
}
