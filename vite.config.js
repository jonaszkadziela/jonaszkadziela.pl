import { defineConfig } from 'vite'
import { PrimeVueResolver } from '@primevue/auto-import-resolver'
import Components from 'unplugin-vue-components/vite'
import laravel, { refreshPaths } from 'laravel-vite-plugin'
import path from 'path'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    resolve: {
        alias: [
            { find: '@', replacement: path.resolve(__dirname, './resources') },
        ],
    },
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/css/app.css',
                'resources/js/admin.js',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Filament/**',
            ],
        }),
        vue(),
        Components({
            resolvers: [
                PrimeVueResolver(),
            ],
        }),
    ],
})
