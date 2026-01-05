import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],
    // Tambahkan bagian ini untuk mendukung JSX di file .js
    esbuild: {
        loader: 'jsx',
        include: /resources\/js\/.*\.js$/,
        exclude: [],
    },
});