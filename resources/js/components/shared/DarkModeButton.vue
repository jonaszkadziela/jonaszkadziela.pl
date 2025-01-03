<template>
    <Button :icon="darkModeIcon"
            aria-label="Dark mode"
            @click="toggleDarkMode"
    />
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps(['darkMode'])

const darkModeIcon = computed(() => props.darkMode ? 'fa fa-moon' : 'fa fa-sun')

function toggleDarkMode() {
    return props.darkMode ? document.body.parentNode.classList.replace('dark', 'light') : document.body.parentNode.classList.replace('light', 'dark')
}
</script>
