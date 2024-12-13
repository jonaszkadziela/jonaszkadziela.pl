<template>
    <DefaultLayout>
        <Button aria-label="Dark mode"
                class="fixed bottom-5 right-5 z-50"
                :icon="darkModeIcon"
                @click="toggleDarkMode"
        />
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from './layouts/DefaultLayout.vue'
import {
    computed,
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const darkMode = ref(false)
const html = document.body.parentNode

function toggleDarkMode() {
    return darkMode.value ? html.classList.replace('dark', 'light') : html.classList.replace('light', 'dark')
}

const mutationObserver = new MutationObserver(([ entry ]) => {
    if (entry.attributeName === 'class') {
        darkMode.value = entry.target.classList.contains('dark')
    }
})

const darkModeIcon = computed(() => darkMode.value ? 'fa fa-moon' : 'fa fa-sun')

onMounted(() => {
    darkMode.value = html.classList.contains('dark')

    mutationObserver.observe(html, { attributes: true })
})
onBeforeUnmount(() => {
    mutationObserver.disconnect()
})
</script>
