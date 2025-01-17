<template>
    <section :id="section.id"
             :class="section.class"
    >
        <h3 v-if="section.showTitle"
            class="text-2xl font-bold uppercase"
        >
            {{ getTranslation(translations, section.title) }}
        </h3>
        <div v-if="section.showSplitter"
             class="border border-black dark:border-white my-4"
        ></div>
        <component :is="components[section.type]"
                   :section="section"
                   :translations="translations"
        />
    </section>
</template>

<script setup>
import { defineAsyncComponent } from 'vue'

defineProps({
    section: Object,
    translations: Object,
})

const components = {
    ChronologicalListSection: defineAsyncComponent(() => import('./ChronologicalListSection.vue')),
    DoughnutChartSection: defineAsyncComponent(() => import('./DoughnutChartSection.vue')),
    FooterSection: defineAsyncComponent(() => import('./FooterSection.vue')),
    GroupedChipsSection: defineAsyncComponent(() => import('./GroupedChipsSection.vue')),
    HeaderSection: defineAsyncComponent(() => import('./HeaderSection.vue')),
    IconWithLabelSection: defineAsyncComponent(() => import('./IconWithLabelSection.vue')),
    LevelWithLabelSection: defineAsyncComponent(() => import('./LevelWithLabelSection.vue')),
    LinkSection: defineAsyncComponent(() => import('./LinkSection.vue')),
    ParagraphSection: defineAsyncComponent(() => import('./ParagraphSection.vue')),
    TimelineSection: defineAsyncComponent(() => import('./TimelineSection.vue')),
}
</script>
