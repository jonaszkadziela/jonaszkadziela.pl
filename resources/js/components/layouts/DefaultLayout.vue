<template>
    <div class="flex flex-col min-h-screen">
        <NavBar :dark-mode="props.darkMode"
                :menu-data="props.menuData"
        />
        <main class="flex-1 py-4">
            <Toast class="max-w-72 md:max-w-full"
                   position="bottom-right"
            />
            <slot />
        </main>
        <Footer :menu-data="props.menuData" />
    </div>
</template>

<script setup>
import Footer from '../shared/Footer.vue'
import NavBar from '../shared/NavBar.vue'

const props = defineProps({
    darkMode: Boolean,
    menuData: Array,
})
</script>
