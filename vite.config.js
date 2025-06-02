import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            // Force asset URLs to use the same scheme as the current request
            // This ensures that when the site is accessed over HTTPS, assets are also served over HTTPS
            https: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        // Enable HTTPS for development server
        https: true,
    },
});
