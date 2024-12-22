import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

const colors = require('tailwindcss/colors')

export default {
    presets: [preset],
    darkMode: 'class',
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        'resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
          colors: {
            purple:'#a78bfa',
            green : '#86efac'
          },
        },
      },
      plugins: [],
}
