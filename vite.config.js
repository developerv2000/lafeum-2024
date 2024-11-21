import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // Front styles
                'resources/css/front/main.css',
                'resources/css/front/auth.css',

                // Dashboard styles
                'resources/css/dashboard/main.css',
                'resources/css/dashboard/themes/light.css',
                'resources/css/dashboard/themes/dark.css',

                // Front js
                'resources/js/front/main.js',
                'resources/js/front/auth.js',

                // Dashboard js
                'resources/js/dashboard/main.js',
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

