<template>
    <Card :pt="{
        body: 'p-6',
        root: 'border dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl shadow-none transition-shadow',
    }">
        <template #header>
            <Image :src="document.image"
                   :pt="{
                       root: 'h-64 w-full',
                       image: 'border-b object-contain rounded-t-xl w-full',
                       mask: 'overflow-auto',
                       previewMask: 'rounded-t-xl',
                       toolbar: 'z-[101]',
                   }"
                   :alt="`Document - ${getTranslation(document.translations, document.title)}`"
                   preview
            >
                <template #original="slotProps">
                    <div class="flex flex-col gap-4 h-max items-center w-min p-4">
                        <img :src="document.image"
                             :style="slotProps.style"
                             :class="slotProps.class"
                             class="max-h-[90vh] z-[100]"
                             @click="event => event.stopPropagation()"
                        >
                        <Panel v-if="document.body"
                               :collapsed="true"
                               :header="Lang.get('main.description')"
                               class="w-full"
                               toggleable
                               @click="event => event.stopPropagation()"
                        >
                            <p>
                                {{ getTranslation(document.translations, document.body) }}
                            </p>
                        </Panel>
                    </div>
                </template>
            </Image>
        </template>
        <template #title>
            <RouterLink :to="`/documents/${document.slug}`">
                <h4 class="font-semibold text-3xl">
                    {{ getTranslation(document.translations, document.title) }}
                </h4>
            </RouterLink>
        </template>
    </Card>
</template>

<script setup>
defineProps({
    document: Object,
})
</script>
