import { defineConfig } from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

import autoprefixer from 'autoprefixer';
import tailwindcss from '@tailwindcss/vite'
export default defineConfig({

    plugins: [

        tailwindcss(),
        autoprefixer(),
        laravel({
            input: ['resources/css/public.css','resources/css/app.css','resources/js/app.js'],

            refresh: [

                ... refreshPaths,
                'app/Livewire/**',
                'app/Filament/**',
            ],

        }),
    ],
});
