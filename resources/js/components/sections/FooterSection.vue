<template>
    <div class="cv-width mx-auto px-12 py-4">
        <p class="dark:text-black justify text-sm text-white">
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
