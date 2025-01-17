<template>
    <div class="flex flex-col gap-4">
        <div v-for="item in section.data"
             :key="item.title"
        >
            <a :href="getTranslation(translations, item.link)"
               class="gap-4 group inline-flex items-center"
               target="_blank"
            >
                <i :class="item.icon" class="fa-fw fa-lg"></i>
                <span class="dark:text-gray-300 group-hover:underline text-gray-600 underline-offset-8">
                    {{ getTranslation(translations, item.title) }}
                </span>
            </a>
        </div>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
