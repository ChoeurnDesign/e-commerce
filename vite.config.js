import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig({
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources/js"),
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", 
                    "resources/js/app.js"
                  ],
            define: {
                "import.meta.env.VITE_PUSHER_APP_KEY": JSON.stringify(
                    process.env.PUSHER_APP_KEY
                ),
                "import.meta.env.VITE_PUSHER_APP_CLUSTER": JSON.stringify(
                    process.env.PUSHER_APP_CLUSTER
                ),
            },
            refresh: [
                "resources/views/**",
                "routes/**",
                // 'app/Http/Livewire/**', // uncomment if using Livewire
            ],
        }),
    ],
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ["alpinejs", "axios"],
                },
            },
        },
    },
});
