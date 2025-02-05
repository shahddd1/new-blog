import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: path.resolve(__dirname, 'public/build'),
    manifest: true,
    rollupOptions: {
      input: path.resolve(__dirname, 'resources/js/app.js'),
    },
  },
});
