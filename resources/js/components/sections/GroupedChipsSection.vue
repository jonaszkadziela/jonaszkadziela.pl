<template>
    <div class="gap-4 grid grid-cols-2">
        <div v-for="(values, key) in section.data"
             :key="key"
        >
            <p class="font-semibold mb-2 text-lg">
                {{ getTranslation(translations, key) }}
            </p>
            <div class="flex flex-wrap gap-2 text-xs">
                <Chip v-for="value in values"
                      :key="value"
                      :label="getTranslation(translations, value)"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
