<template>
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="font-bold mb-8 sm:text-6xl text-4xl">
            {{ getTranslation(translations, section.title) }}
        </h1>
        <div class="dark:text-gray-300 formatted-html text-gray-600 text-lg"
             v-html="getTranslation(translations, section.body)"
        ></div>
    </div>
    <template v-if="section.showButton">
        <Button :label="getTranslation(translations, section.buttonLabel)"
                :href="section.buttonHref"
                as="a"
                class="-mb-6 absolute bg-blue-50 border-blue-50 bottom-0 dark:bg-blue-950 dark:border-blue-950 dark:hover:bg-blue-900 dark:text-blue-100 hover:bg-blue-100 text-blue-900"
                icon="fa fa-chevron-down"
                iconPos="right"
                severity="secondary"
                rounded
        />
    </template>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
