<template>
    <div :class="section.markdownClass">
        <div v-html="DOMPurify.sanitize(marked.parse(getTranslation(translations, section.body)))"
             class="dark:text-gray-300 formatted-html text-gray-600"
        ></div>
    </div>
</template>

<script setup>
import { marked } from 'marked'
import DOMPurify from 'dompurify'

defineProps({
    section: Object,
    translations: Object,
})
</script>
