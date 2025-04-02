export default {
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
      './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
      './storage/framework/views/*.php',
    ],
    safelist: [
      {
        pattern: /border-blue-400/,
        variants: ['hover'],
      },
    ],
    theme: {
      extend: {
        fontFamily: {
          sans: [
            'Instrument Sans',
            'ui-sans-serif',
            'system-ui',
            'sans-serif',
            'Apple Color Emoji',
            'Segoe UI Emoji',
            'Segoe UI Symbol',
            'Noto Color Emoji',
          ],
        },
        colors: {
          yellow: {
            50: '#fffbeb',
            100: '#fef3c7',
            200: '#fde68a',
            300: '#fcd34d',
            400: '#fbbf24',
            500: '#f59e0b', // bg-yellow-500 に対応
            600: '#d97706',
            700: '#b45309',
            800: '#92400e',
            900: '#78350f',
          },
        },
      },
    },
    plugins: [],
  };