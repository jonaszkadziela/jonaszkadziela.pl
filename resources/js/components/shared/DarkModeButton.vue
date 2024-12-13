<template>
    <Button aria-label="Dark mode"
            class="fixed bottom-5 right-5 z-50"
            :icon="darkModeIcon"
            @click="toggleDarkMode"
    />
</template>

<script setup>
import {
    computed,
    defineProps,
} from 'vue'

const props = defineProps(['darkMode'])

function toggleDarkMode() {
    return props.darkMode ? document.body.parentNode.classList.replace('dark', 'light') : document.body.parentNode.classList.replace('light', 'dark')
}

const darkModeIcon = computed(() => props.darkMode ? 'fa fa-moon' : 'fa fa-sun')
</script>
