<template>
    <div class="flex flex-col gap-4">
        <div v-for="item in section.data"
             :key="item.title"
        >
            <p class="font-bold text-lg">
                {{ getTranslation(translations, item.title) }}
            </p>
            <p class="dark:text-gray-300 text-gray-600">
                {{ getTranslation(translations, item.date) }}
            </p>
        </div>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
