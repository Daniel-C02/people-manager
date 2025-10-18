import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@js": path.resolve(__dirname, "resources/js"),
            "@fonts": path.resolve(__dirname, "resources/fonts"),
            "@scss": path.resolve(__dirname, "resources/scss"),
        },
    },
    build: {
        outDir: 'public/build',
        rollupOptions: {
            input: {
                main: 'resources/js/app.js',
            },
        },
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: false,
            },
        },
    },
});
