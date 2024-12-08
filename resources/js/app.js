import './bootstrap'
import { createApp } from 'vue'
import { definePreset } from '@primevue/themes'
import App from './components/App.vue'
import Aura from '@primevue/themes/aura'
import PrimeVue from 'primevue/config'

const app = createApp(App)

const customPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{blue.50}',
            100: '{blue.100}',
            200: '{blue.200}',
            300: '{blue.300}',
            400: '{blue.400}',
            500: '{blue.500}',
            600: '{blue.600}',
            700: '{blue.700}',
            800: '{blue.800}',
            900: '{blue.900}',
            950: '{blue.950}',
        },
    },
})

app.use(PrimeVue, {
    theme: {
        preset: customPreset,
    },
})

app.mount('#app')
