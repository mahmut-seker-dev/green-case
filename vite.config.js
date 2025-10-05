import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/js/app.js',

                // 👇 Yeni sayfalar:
                'resources/js/pages/trashedCustomers.js',
                'resources/js/pages/trashedUsers.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jquery',
        },
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                manualChunks: {
                    // DataTables bağımlılıklarını ayrı chunk olarak al
                    datatables: [
                        'datatables.net-bs5',
                        'datatables.net-responsive-bs5'
                    ],
                },
            },
        },
    },
});
