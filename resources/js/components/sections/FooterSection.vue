<template>
    <div class="cv-width mx-auto px-12 py-4">
        <p class="dark:text-gray-300 justify text-sm text-white">
            {{ getTranslation(translations, section.body) }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
