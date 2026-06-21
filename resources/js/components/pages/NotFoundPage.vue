<template>
    <NotFoundSection />
</template>

<script setup>
import NotFoundSection from '../shared/NotFoundSection.vue'

defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})
</script>
