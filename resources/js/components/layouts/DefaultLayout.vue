<template>
    <div class="flex flex-col min-h-screen">
        <NavBar :dark-mode="props.darkMode" />
        <main class="flex-1 py-4">
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup>
import Footer from '../shared/Footer.vue'
import NavBar from '../shared/NavBar.vue'

const props = defineProps(['darkMode'])
</script>
