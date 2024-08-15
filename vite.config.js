import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/front/main.css',
                'resources/css/front/auth.css',
                'resources/css/dashboard/dashboard.css',
                'resources/js/front/main.js',
                'resources/js/dashboard/dashboard.js',
            ],
            refresh: true,
        }),
    ],
    publicDir: 'public',
    base: '/',
    build: {
        assetsDir: '',
        copyPublicDir: false,
    },
});

