import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  server: {
        allowedHosts: ['reliable-education-production-3683.up.railway.app']
    },
})
