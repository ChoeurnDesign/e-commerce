import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: [
        'resources/views/**',
        'routes/**',
        // 'app/Http/Livewire/**', // uncomment if using Livewire
      ],
    }),
  ],
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          vendor: [
            'alpinejs',
            'axios',
          ],
        },
      },
    },
  },
});