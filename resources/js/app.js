import './bootstrap'
import '@fortawesome/fontawesome-free/css/all.css'
import { createApp } from 'vue'
import { definePreset } from '@primevue/themes'
import { getTranslation, hasTranslation } from './translation.js'
import App from './components/App.vue'
import Aura from '@primevue/themes/aura'
import ConfirmationService from 'primevue/confirmationservice'
import PrimeVue from 'primevue/config'
import Router from './router'
import ToastService from 'primevue/toastservice'
import Tooltip from 'primevue/tooltip'
import.meta.glob([
    '../images/**',
])

const app = createApp(App)

app.config.globalProperties.Lang = Lang

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

app.use(ConfirmationService)
app.use(Router)
app.use(ToastService)
app.use(PrimeVue, {
    theme: {
        options: {
            cssLayer: {
                name: 'primevue',
                order: 'tailwind-base, primevue, tailwind-utilities',
            },
            darkModeSelector: 'html.dark',
        },
        preset: customPreset,
    },
})

app.directive('tooltip', Tooltip)

app.mixin({
    methods: {
        getTranslation,
        hasTranslation,
    },
})

app.mount('#app')
