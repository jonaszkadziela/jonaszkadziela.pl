<template>
    <div :class="section.markdownClass">
        <div v-html="DOMPurify.sanitize(marked.parse(getTranslation(translations, section.body)))"
             class="dark:text-gray-300 formatted-html text-gray-600"
        ></div>
    </div>
</template>

<script setup>
import DOMPurify from 'dompurify'
import { marked } from 'marked'

defineProps({
    section: Object,
    translations: Object,
})
</script>
