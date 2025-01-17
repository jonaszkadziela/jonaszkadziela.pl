import defaultTheme from 'tailwindcss/defaultTheme'

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: ['variant', [
        '@media (prefers-color-scheme: dark) { &:not(.light *) }',
        '&:is(.dark *)',
    ]],
    plugins: [],
    safelist: [
        '-mb-4',
        '-mt-4',
        'bg-gradient-to-br',
        'w-12',
        'w-20',
        'w-44',
    ],
    theme: {
        extend: {
            animation: {
                'fade-in': 'fade-in 4s ease-in',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'fade-in': {
                    '0%': { opacity: 0 },
                    '50%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
            },
        },
    },
}
