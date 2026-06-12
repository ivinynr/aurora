import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
        tailwindcss(),
    ],
    server: {
        host: true,
        port: 5175,
        hmr: {
            host: 'localhost',
            port: 5175,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
