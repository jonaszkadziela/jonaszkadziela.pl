<template>
    <div class="flex flex-wrap gap-2">
        <Tag v-for="(tag, index) in tags.slice(0, limit)"
             :key="tag.name"
             :pt="pt"
             :severity="highlightFirst && index === 0 ? 'primary' : 'secondary'"
             :value="getTranslation(tag.translations, tag.name)"
             rounded
        />
        <Tag v-if="tags.length > limit"
             :pt="pt"
             :value="`+${tags.length - limit}`"
             severity="secondary"
             rounded
        />
    </div>
</template>

<script setup>
defineProps({
    tags: Array,
    limit: {
        type: Number,
        required: false,
        default: 100,
    },
    highlightFirst: {
        type: Boolean,
        required: false,
        default: true,
    },
    pt: {
        type: Object,
        required: false,
        default: () => {},
    },
})
</script>
