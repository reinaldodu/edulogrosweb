import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import fs from 'fs'; 
const host = 'edulogrosweb.test'; // Your local development host

export default defineConfig({

    server: { 
        host, 
        hmr: { host },
        https: { 
            key: fs.readFileSync(`C:/laragon/etc/ssl/laragon.key`), // [!tl add]
            cert: fs.readFileSync(`C:/laragon/etc/ssl/laragon.crt`), // [!tl add]
        }, 
    },

    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
