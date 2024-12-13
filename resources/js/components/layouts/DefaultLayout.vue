<template>
    <div class="min-h-screen">
        <NavBar :dark-mode="props.darkMode" />
        <main class="py-4">
            <slot />
        </main>
    </div>
</template>

<script setup>
import NavBar from '../shared/NavBar.vue'
import { defineProps } from 'vue'

const props = defineProps(['darkMode'])
</script>
