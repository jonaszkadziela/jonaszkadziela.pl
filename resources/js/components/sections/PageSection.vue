<template>
    <section :id="section.id"
             :class="section.class"
    >
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
    ContainerSection: defineAsyncComponent(() => import('./ContainerSection.vue')),
    DoughnutChartSection: defineAsyncComponent(() => import('./DoughnutChartSection.vue')),
    FooterSection: defineAsyncComponent(() => import('./FooterSection.vue')),
    GroupedChipsSection: defineAsyncComponent(() => import('./GroupedChipsSection.vue')),
    HeaderSection: defineAsyncComponent(() => import('./HeaderSection.vue')),
    IconWithLabelSection: defineAsyncComponent(() => import('./IconWithLabelSection.vue')),
    LevelWithLabelSection: defineAsyncComponent(() => import('./LevelWithLabelSection.vue')),
    LinkSection: defineAsyncComponent(() => import('./LinkSection.vue')),
    MarkdownSection: defineAsyncComponent(() => import('./MarkdownSection.vue')),
    ParagraphSection: defineAsyncComponent(() => import('./ParagraphSection.vue')),
    TimelineSection: defineAsyncComponent(() => import('./TimelineSection.vue')),
}
</script>
