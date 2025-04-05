<template>
    <Card :pt="{
        body: 'gap-0 h-full p-0',
        caption: 'h-full',
        root: 'dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl shadow-none transition-shadow',
        title: 'h-full',
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
                   :alt="`${Lang.get('document.document')} - ${getTranslation(document.translations, document.title)}`"
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
            <RouterLink :to="`/documents/${document.slug}`"
                        class="flex gap-6 group h-full justify-between p-6"
            >
                <h4 class="duration-300 font-semibold group-hover:text-blue-700 text-3xl">
                    {{ getTranslation(document.translations, document.title) }}
                </h4>
                <div class="-translate-x-4 duration-300 group-hover:opacity-100 group-hover:translate-x-0 opacity-0 right-5 text-2xl text-blue-700 top-5 transition-transform">
                    <i class="fa fa-arrow-right"></i>
                </div>
            </RouterLink>
        </template>
    </Card>
</template>

<script setup>
defineProps({
    document: Object,
})
</script>
