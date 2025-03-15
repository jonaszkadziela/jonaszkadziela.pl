<template>
    <div class="flex flex-col min-h-screen">
        <NavBar :dark-mode="props.darkMode"
                :menu-data="props.menuData"
        />
        <main class="flex-1">
            <Toast class="max-w-72 md:max-w-full"
                   position="bottom-right"
            />
            <slot />
            <FeedbackButton v-if="appStore.optionalFeatures.feedback"
                            class="fixed left-4 bottom-4"
            />
        </main>
        <Footer :menu-data="props.menuData"
                :social-data="socialData"
        />
    </div>
</template>

<script setup>
import FeedbackButton from '../shared/FeedbackButton.vue'
import Footer from '../shared/Footer.vue'
import NavBar from '../shared/NavBar.vue'
import { appStore } from '../../store/app.js'

const props = defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})
</script>
