<template>
    <div class="flex flex-col gap-4">
        <div v-for="item in section.data"
             :key="item.title"
             class="gap-4 group inline-flex items-center"
        >
            <div class="bg-gray-900 dark:bg-gray-600 flex items-center justify-center rounded-full size-12">
                <i :class="item.icon"
                   class="fa-fw fa-lg text-white"
                ></i>
            </div>
            <span class="dark:text-gray-300 text-gray-600">
                {{ getTranslation(translations, item.title) }}
            </span>
        </div>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
