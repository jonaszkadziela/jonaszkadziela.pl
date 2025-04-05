<template>
    <div class="flex flex-wrap gap-2">
        <Tag v-for="(tag, index) in tags.slice(0, limit)"
             v-tooltip.top="{
                 pt: {
                     root: 'md:min-w-max',
                 },
                 value: Lang.get('main.tags.search', { tag: getTranslation(tag.translations, tag.name) }),
             }"
             :key="tag.name"
             :pt="pt"
             :severity="highlightFirst && index === 0 ? 'primary' : 'secondary'"
             :value="getTranslation(tag.translations, tag.name)"
             @click="searchByTags(tag.name)"
             class="cursor-pointer dark:hover:brightness-150 hover:brightness-90 transition"
             rounded
        />
        <Tag v-if="tags.length > limit"
             v-tooltip.top="Lang.get('main.tags.more')"
             :pt="pt"
             :value="`+${tags.length - limit}`"
             severity="secondary"
             class="cursor-help"
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

function searchByTags(tagName) {
    window.location.assign(`/search/by-tags?tags[]=${encodeURIComponent(tagName)}`)
}
</script>
