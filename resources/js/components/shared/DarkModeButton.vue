<template>
    <Button :icon="darkModeIcon"
            aria-label="Dark mode"
            @click="toggleDarkMode"
    />
</template>

<script setup>
import {
    computed,
    onMounted,
} from 'vue'

const props = defineProps(['darkMode'])
const darkModeIcon = computed(() => props.darkMode ? 'fa fa-moon' : 'fa fa-sun')
const html = document.body.parentNode

function toggleDarkMode() {
    props.darkMode ? html.classList.replace('dark', 'light') : html.classList.replace('light', 'dark')

    axios.post(`/theme/${props.darkMode ? 'light' : 'dark'}`)
        .catch(() => {})
}

onMounted(() => {
    if (html.classList.contains('light') || html.classList.contains('dark')) {
        return
    }

    html.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches)
    html.classList.toggle('light', window.matchMedia('(prefers-color-scheme: light)').matches)
})
</script>
