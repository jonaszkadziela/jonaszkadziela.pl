<template>
    <div class="gap-4 grid grid-cols-2">
        <div v-for="(values, key) in section.data"
             :key="key"
        >
            <p class="font-semibold mb-2 text-lg">
                {{ getTranslation(translations, key) }}
            </p>
            <div class="flex flex-wrap gap-2 text-xs">
                <template v-if="section.actsAsTag">
                    <Chip v-for="value in values"
                          v-tooltip.top="{
                              pt: {
                                  root: 'md:min-w-max',
                              },
                              value: Lang.get('main.tags.search', { tag: getTranslation(translations, value) }),
                          }"
                          :key="value"
                          :label="getTranslation(translations, value)"
                          @click="searchByTags(value)"
                          class="cursor-pointer dark:hover:brightness-150 hover:brightness-90 transition"
                    />
                </template>
                <template v-else>
                    <Chip v-for="value in values"
                          :key="value"
                          :label="getTranslation(translations, value)"
                    />
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})

function searchByTags(tagName) {
    window.location.assign(`/search/by-tags?tags[]=${encodeURIComponent(tagName)}`)
}
</script>
