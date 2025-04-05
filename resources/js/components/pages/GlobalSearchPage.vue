<template>
    <LoadingScreen :loading="loading" />
    <template v-if="!loading && data">
        <section id="global-search"
                 class="container flex flex-col gap-16 items-center mx-auto px-4 py-16 relative"
        >
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="font-bold mb-8 sm:text-6xl text-4xl">
                    {{ Lang.get('search.title') }}
                </h1>
                <div v-if="route.params.type === 'by-tags'"
                     class="mb-8"
                >
                    <h3 class="dark:text-gray-300 mb-4 text-gray-600 text-lg">
                        {{ Lang.get('search.searched-by-tags') }}:
                    </h3>
                    <TagsList :highlight-first="false"
                              :tags="data.tags"
                              class="justify-center"
                    />
                </div>
                <p class="dark:text-gray-300 text-gray-600 text-lg">
                    {{ Lang.get('search.description') }}.
                </p>
            </div>
            <SectionButton :label="Lang.get('main.buttons.see-more')"
                           as="a"
                           href="#results"
            />
        </section>
        <section id="results"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 flex flex-col gap-16 py-16 text-blue-900"
        >
            <Panel v-for="resultType in Object.keys(data.results)"
                   :header="Lang.get(`search.results.${resultType}`) + ' (' + data.results[resultType].length + ')'"
                   :key="resultType"
                   :pt="{
                       header: 'font-semibold mb-1 md:text-3xl text-2xl',
                       root: 'border-none bg-transparent',
                   }"
                   class="container mx-auto px-4"
                   toggleable
            >
                <template v-if="Array.isArray(data.results[resultType]) && data.results[resultType].length > 0">
                    <div v-if="resultType === 'documents'"
                         class="gap-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4"
                    >
                        <DocumentCard v-for="document in data.results[resultType]"
                                      :document="document"
                                      :key="document.slug"
                        />
                    </div>
                    <div v-else-if="resultType === 'posts'"
                         class="flex flex-wrap gap-8 justify-center"
                    >
                        <PostCard v-for="post in data.results[resultType]"
                                  :key="post.slug"
                                  :post="post"
                                  class="md:w-[calc(50%-16px)]"
                        />
                    </div>
                    <div v-else-if="resultType === 'projects'"
                         class="grid grid-cols-1 gap-8"
                    >
                        <ProjectCard v-for="project in data.results[resultType]"
                                     :key="project.slug"
                                     :project="project"
                        />
                    </div>
                </template>
                <p v-else>
                    {{ Lang.get('search.no-results') }}
                </p>
            </Panel>
        </section>
    </template>
</template>

<script setup>
import DocumentCard from '../shared/DocumentCard.vue'
import LoadingScreen from '../shared/LoadingScreen.vue'
import PostCard from '../shared/PostCard.vue'
import ProjectCard from '../shared/ProjectCard.vue'
import SectionButton from '../shared/SectionButton.vue'
import TagsList from '../shared/TagsList.vue'
import {
    onMounted,
    ref,
} from 'vue'
import { useRoute } from 'vue-router'
import { useToast } from 'primevue/usetoast'

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
    axios
        .get(`/search/${route.params.type}${location.search}`)
        .then(response => data.value = response.data.data)
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
        }))
        .finally(() => loading.value = false)
})
</script>
