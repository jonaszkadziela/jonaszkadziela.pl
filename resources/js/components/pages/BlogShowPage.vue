<template>
    <LoadingScreen :loading="loading" />
    <template v-if="!loading && data">
        <section :style="`background-image: url(${data.image});`"
                 id="title"
                 class="bg-center bg-contain min-h-80 relative"
        >
            <div class="absolute bg-gradient-to-t bottom-0 dark:from-zinc-900 dark:via-zinc-900/70 from-white left-0 right-0 to-transparent top-0 via-white/70">
                <div class="container flex flex-col gap-6 h-full items-center justify-end mx-auto">
                    <h1 class="font-bold sm:text-6xl text-4xl text-center">
                        {{ getTranslation(data.translations, data.title) }}
                    </h1>
                    <div class="flex flex-wrap gap-2 mb-16">
                        <Tag v-for="(tag, index) in data.tags"
                             :key="tag.name"
                             :severity="index === 0 ? 'primary' : 'secondary'"
                             :value="getTranslation(tag.translations, tag.name)"
                             rounded
                        />
                    </div>
                </div>
            </div>
        </section>
        <section id="body"
                 class="max-w-4xl mx-auto px-4 py-16"
        >
            <div v-html="DOMPurify.sanitize(getTranslation(data.translations, data.body))"
                 class="formatted-html"
            ></div>
            <div class="dark:text-gray-300 italic mt-8 text-gray-600">
                {{ Lang.get('blog.published') }}
                {{ data.user ? `${Lang.get('blog.by')} ${data.user.name}` : '' }}
                {{ data.publishedAt }}
            </div>
        </section>
    </template>
</template>

<script setup>
import DOMPurify from 'dompurify'
import LoadingScreen from '../shared/LoadingScreen.vue'
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
        .get(`/posts/${route.params.slug}`)
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
