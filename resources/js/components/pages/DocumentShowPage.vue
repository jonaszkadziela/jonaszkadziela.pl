<template>
    <LoadingScreen :loading="loading" />
    <template v-if="!loading && data">
        <section id="summary"
                 class="flex flex-col gap-16 items-center px-4 py-16 relative"
        >
            <div class="max-w-2xl mb-4 mx-auto text-center">
                <h1 class="font-bold mb-10 sm:text-6xl text-4xl">
                    {{ getTranslation(data.translations, data.title) }}
                </h1>
                <div class="flex flex-wrap gap-2 justify-center mb-8">
                    <Tag v-for="(tag, index) in data.tags"
                         :key="tag.name"
                         :severity="index === 0 ? 'primary' : 'secondary'"
                         :value="getTranslation(tag.translations, tag.name)"
                         rounded
                    />
                </div>
                <p class="dark:text-gray-300 mb-4 text-gray-600 text-lg">
                    {{ getTranslation(data.translations, data.body) }}
                </p>
                <p class="dark:text-gray-300 text-gray-600 text-lg">
                    {{ `${Lang.get('document.show.summary.issued')} ${data.issuedAt}` }}
                </p>
            </div>
            <SectionButton :label="Lang.get('main.buttons.see-more')"
                           as="a"
                           href="#related-files"
            />
        </section>
        <section id="related-files"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 project-description py-16 text-blue-900"
        >
            <div class="container mx-auto px-4 text-center">
                <div class="max-w-2xl mb-16 mx-auto">
                    <h3 class="text-4xl font-bold">
                        {{ Lang.get('document.show.related-files.title') }}
                    </h3>
                </div>
                <div class="flex flex-col gap-4 w-1/2 mx-auto">
                    <Image :src="data.image"
                           :pt="{
                               mask: 'overflow-auto',
                               toolbar: 'z-[101]',
                           }"
                           :alt="`File - ${getTranslation(data.translations, data.title)}`"
                           preview
                    >
                        <template #original="slotProps">
                            <div class="flex flex-col gap-4 h-max items-center p-4 w-min">
                                <img :src="data.image"
                                     :style="slotProps.style"
                                     :class="slotProps.class"
                                     class="max-h-[90vh] z-[100]"
                                     @click="event => event.stopPropagation()"
                                >
                                <Panel v-if="data.body"
                                       :collapsed="true"
                                       :header="Lang.get('main.description')"
                                       class="w-full"
                                       toggleable
                                       @click="event => event.stopPropagation()"
                                >
                                    <p>
                                        {{ getTranslation(data.translations, data.body) }}
                                    </p>
                                </Panel>
                            </div>
                        </template>
                    </Image>
                </div>
            </div>
        </section>
    </template>
</template>

<script setup>
import LoadingScreen from '../shared/LoadingScreen.vue'
import SectionButton from '../shared/SectionButton.vue'
import { getTranslation } from '../../translation.js'
import { useRoute } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import {
    onMounted,
    ref,
} from 'vue'

defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})

const toast = useToast()
const route = useRoute()

const data = ref(null)
const loading = ref(true)

onMounted(() => {
    const initialTitle = document.title

    axios
        .get(`/documents/${route.params.slug}`)
        .then(response => {
            data.value = response.data.data

            document.title = `${getTranslation(data.value.translations, data.value.title)} - ${initialTitle}`
        })
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
        }))
        .finally(() => loading.value = false)
})
</script>
