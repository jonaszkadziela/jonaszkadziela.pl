<template>
    <div class="flex flex-col gap-4">
        <div v-for="item in section.data"
             :key="item.title"
        >
            <p class="dark:text-gray-300 mb-1 text-gray-600 text-lg">
                {{ getTranslation(translations, item.title) }}
            </p>
            <div class="flex gap-2">
                <div v-for="index in [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]"
                     :key="index"
                     class="color-black dark:color-white fa-xl"
                >
                    <i :class="item.level >= index ? 'fa-solid fa-circle' : 'fa-regular fa-circle'"></i>
                </div>
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
