import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // app.css/app.js = panel admin (Tailwind, bawaan Breeze).
            // design/styles.css + design/site.js = aset desain final untuk halaman
            // publik, dipakai apa adanya via @vite([...]) di layout publik.
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'design/styles.css',
                'design/site.js',
            ],
            refresh: true,
        }),
    ],
});
