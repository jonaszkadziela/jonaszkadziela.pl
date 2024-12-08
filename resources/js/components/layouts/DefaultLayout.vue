<template>
    <div class="min-h-screen">
        <NavBar />
        <main class="container mx-auto py-2">
            <Button label="Toggle dark mode" class="mb-4 mt-2" @click="toggleDarkMode" />
            <slot />
        </main>
    </div>
</template>

<script setup>
import NavBar from '../shared/NavBar.vue'

const html = document.getElementsByTagName('html')[0]
const toggleDarkMode = () => html.classList.contains('dark') ? html.classList.replace('dark', 'light') : html.classList.replace('light', 'dark')
</script>
