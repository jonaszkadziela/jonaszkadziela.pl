<template>
    <DefaultLayout :dark-mode="darkMode">
        <DarkModeButton :dark-mode="darkMode" />
    </DefaultLayout>
</template>

<script setup>
import DarkModeButton from './shared/DarkModeButton.vue'
import DefaultLayout from './layouts/DefaultLayout.vue'
import {
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const darkMode = ref(false)

const mutationObserver = new MutationObserver(([ entry ]) => {
    if (entry.attributeName === 'class') {
        darkMode.value = entry.target.classList.contains('dark')
    }
})

onMounted(() => {
    darkMode.value = document.body.parentNode.classList.contains('dark')
    mutationObserver.observe(document.body.parentNode, { attributes: true })
})
onBeforeUnmount(() => {
    mutationObserver.disconnect()
})
</script>
