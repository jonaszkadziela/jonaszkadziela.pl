<template>
    <LoadingScreen :loading="loading" />
    <template v-if="!loading && data">
        <section id="blog"
                 class="container flex flex-col gap-16 items-center mx-auto px-4 py-16"
        >
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="font-bold mb-8 sm:text-6xl text-4xl">
                    {{ Lang.get('blog.title') }}
                </h1>
                <p class="dark:text-gray-300 text-gray-600 text-lg">
                    {{ Lang.get('blog.description') }}
                </p>
            </div>
            <div v-if="isInitialRequest && data[0] === undefined && Object.keys(activeFilters).length === 0"
                 class="font-semibold text-lg"
            >
                {{ Lang.get('blog.status.no-published-posts') }}
            </div>
            <div v-else
                 class="w-full"
            >
                <Panel :header="Lang.get('blog.filters.header')"
                       :pt="{
                           header: 'font-semibold mb-1 md:text-3xl text-2xl',
                           root: 'float-left mb-8 md:mb-0 md:sticky md:top-24 md:w-1/3 rounded-xl w-full',
                       }"
                       toggleable
                >
                    <div class="flex flex-col gap-4">
                        <FloatLabel class="w-full"
                                    variant="on"
                        >
                            <InputText v-model="filters.title"
                                       id="title"
                                       type="text"
                                       fluid
                            />
                            <label for="title">
                                {{ Lang.get('blog.filters.title') }}
                            </label>
                        </FloatLabel>
                        <FloatLabel class="w-full"
                                    variant="on"
                        >
                            <MultiSelect v-model="filters.tags"
                                         :optionLabel="tag => getTranslation(tag.translations, tag.name)"
                                         :options="tags"
                                         appendTo="self"
                                         display="chip"
                                         id="tags"
                                         optionValue="name"
                                         fluid
                                         filter
                            />
                            <label for="tags">
                                {{ Lang.get('blog.filters.tags') }}
                            </label>
                        </FloatLabel>
                    </div>
                    <div class="flex flex-col gap-2 justify-end md:flex-row mt-4">
                        <Button :label="clearing ? `${Lang.get('blog.buttons.clearing')}...` : Lang.get('blog.buttons.clear')"
                                :disabled="filtering"
                                severity="secondary"
                                rounded
                                @click="clearFilters"
                        />
                        <Button :label="applying ? `${Lang.get('blog.buttons.applying')}...` : Lang.get('blog.buttons.apply')"
                                :disabled="filtering"
                                class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl to-blue-900 transition-all"
                                rounded
                                @click="applyFilters"
                        />
                    </div>
                </Panel>
                <div class="float-right md:w-[calc(66%-16px)] w-full">
                    <div class="flex flex-col gap-8 justify-center">
                        <PostCard v-for="post in data"
                                  :key="post.slug"
                                  :post="post"
                                  class="border"
                        />
                        <div v-if="!data[0]"
                             class="font-semibold text-lg"
                        >
                            <p>
                                {{ Lang.get('blog.status.no-filter-results') }}.
                            </p>
                            <p>
                                {{ Lang.get('blog.status.adjust-filters') }}.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </template>
</template>

<script setup>
import LoadingScreen from '../shared/LoadingScreen.vue'
import PostCard from '../shared/PostCard.vue'
import { useToast } from 'primevue/usetoast'
import {
    computed,
    onMounted,
    ref,
} from 'vue'

defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})

const toast = useToast()

const applying = ref(false)
const clearing = ref(false)
const data = ref(null)
const filters = ref({})
const isInitialRequest = ref(false)
const loading = ref(true)
const tags = ref(null)

const activeFilters = computed(() => Object.fromEntries(Object.entries(filters.value).filter(([, value]) => value)))
const filtering = computed(() => applying.value || clearing.value)

function getPosts() {
    isInitialRequest.value = false

    return axios
        .get('/posts', {
            params: activeFilters.value,
        })
        .then(response => data.value = response.data.data)
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
        }))
}

function applyFilters() {
    applying.value = true

    getPosts().finally(() => applying.value = false)
}

function clearFilters() {
    clearing.value = true
    filters.value = {}

    getPosts().finally(() => clearing.value = false)
}

onMounted(() => {
    getPosts().finally(() => {
        isInitialRequest.value = true
        loading.value = false
    })

    axios
        .get('/tags')
        .then(response => tags.value = response.data.data)
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
        }))
})
</script>
