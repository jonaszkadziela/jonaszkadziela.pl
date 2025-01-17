<template>
    <div class="flex flex-col gap-4">
        <p v-for="(text, index) in section.data"
           :key="index"
           class="dark:text-gray-300 text-gray-600 text-justify"
        >
            {{ getTranslation(translations, text) }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
