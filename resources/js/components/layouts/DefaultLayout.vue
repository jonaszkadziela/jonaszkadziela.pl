<template>
    <div class="min-h-screen">
        <NavBar />
        <main class="py-4">
            <slot />
        </main>
    </div>
</template>

<script setup>
import NavBar from '../shared/NavBar.vue'
</script>
