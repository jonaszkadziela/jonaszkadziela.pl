<template>
    <div class="overflow-hidden">
        <Timeline :value="section.data"
                  :pt="{
                      event: 'min-h-4',
                      eventContent: 'mb-4 pr-0',
                      eventOpposite: 'grow-0 pl-0 shrink-0',
                      root: '-mb-8',
                  }"
        >
            <template #opposite="slotProps">
                <p v-if="slotProps.item.period"
                   :class="section.oppositeClass"
                   class="-mt-0.5 font-semibold text-lg"
                >
                    {{ getTranslation(translations, slotProps.item.period) }}
                </p>
            </template>
            <template #marker="slotProps">
                <span v-if="slotProps.item.last">
                </span>
                <span v-else>
                    <i class="fa-solid fa-circle"></i>
                </span>
            </template>
            <template #content="slotProps">
                <p v-if="slotProps.item.title"
                   class="-mt-0.5 font-semibold mb-2 text-lg"
                >
                    {{ getTranslation(translations, slotProps.item.title) }}
                </p>
                <div v-if="slotProps.item.body"
                     v-html="getTranslation(translations, slotProps.item.body)"
                     class="dark:text-gray-300 text-gray-600"
                ></div>
            </template>
        </Timeline>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})
</script>
