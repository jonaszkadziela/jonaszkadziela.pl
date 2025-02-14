<template>
    <LoadingScreen :loading="loading" />
    <template v-if="!loading && data">
        <section id="title"
                 class="flex flex-col gap-16 h-[85vh] items-center latest-project pt-16 relative"
        >
            <div class="max-w-2xl mx-auto px-4 text-center">
                <h1 class="font-bold sm:text-6xl text-4xl">
                    {{ getTranslation(data.translations, data.title) }}
                </h1>
                <Tag v-if="data.isProBono"
                     :value="Lang.get('main.pro-bono')"
                     class="mt-8"
                     icon="fa-hand-holding-dollar fa-solid mr-1"
                     severity="contrast"
                     rounded
                />
            </div>
            <div class="flex flex-1 justify-center overflow-hidden relative w-full">
                <img :src="data.image"
                     :alt="`Project - ${getTranslation(data.translations, data.title)}`"
                     class="md:absolute object-cover"
                >
            </div>
            <Button :label="Lang.get('main.buttons.see-more')"
                    as="a"
                    class="-mb-6 absolute bg-blue-50 border-blue-50 bottom-0 dark:bg-blue-950 dark:border-blue-950 dark:hover:bg-blue-900 dark:text-blue-100 hover:bg-blue-100 text-blue-900"
                    href="#description"
                    icon="fa fa-chevron-down"
                    iconPos="right"
                    severity="secondary"
                    rounded
            />
        </section>
        <section id="description"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 project-description py-16 text-blue-900"
        >
            <div class="container mx-auto px-4 text-center">
                <div class="max-w-2xl mb-16 mx-auto">
                    <h3 class="text-4xl font-bold">
                        {{ Lang.get('portfolio.show.description.title') }}
                    </h3>
                </div>
                <div v-html="getTranslation(data.translations, data.body)"
                     class="dark:text-blue-200 formatted-html text-blue-800"
                ></div>
            </div>
        </section>
        <section id="statistics"
                 class="container mx-auto px-4 py-16"
        >
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold">
                    {{ Lang.get('portfolio.show.statistics.title') }}
                </h3>
            </div>
            <div class="flex flex-wrap gap-4 justify-center">
                <Card v-for="(statistic, index) in statistics"
                      :key="index"
                      :pt="{
                          header: 'pt-6',
                          root: 'border min-w-48 text-center',
                      }"
                >
                    <template #header>
                        <i :class="statistic.icon"
                           class="fa-2xl"
                        ></i>
                    </template>
                    <template #title>
                        <span class="capitalize font-bold text-2xl">
                            {{ statistic.value }}
                        </span>
                    </template>
                    <template #footer>
                        <span class="uppercase text-sm">
                            {{ statistic.label }}
                        </span>
                    </template>
                </Card>
            </div>
        </section>
        <section id="tools-and-technologies"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
        >
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mb-16 mx-auto text-center">
                    <h3 class="text-4xl font-bold">
                        {{ Lang.get('portfolio.show.tools-and-technologies.title') }}
                    </h3>
                </div>
                <div class="flex flex-wrap gap-4 justify-center">
                    <Tag v-for="(tag, index) in data.tags"
                         :key="tag.name"
                         :severity="index === 0 ? 'primary' : 'secondary'"
                         :value="getTranslation(tag.translations, tag.name)"
                         :pt="{
                             root: 'border px-3 py-1.5'
                         }"
                         rounded
                    />
                </div>
            </div>
        </section>
        <section id="explore-more"
                 class="container mx-auto px-4 py-16"
        >
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold">
                    {{ Lang.get('portfolio.show.explore-more.title') }}
                </h3>
            </div>
            <div class="flex flex-col gap-4 md:flex-row justify-center">
                <Button v-if="data.link"
                        :href="data.link"
                        :label="Lang.get('main.buttons.project-page')"
                        as="a"
                        icon="fa-solid fa-up-right-from-square"
                        iconPos="right"
                        severity="secondary"
                        target="_blank"
                        rounded
                />
            </div>
        </section>
    </template>
</template>

<script setup>
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
const statistics = ref(null)

onMounted(() => {
    const initialTitle = document.title

    axios
        .get(`/projects/${route.params.slug}`)
        .then(response => {
            data.value = response.data.data
            statistics.value = [
                {
                    icon: 'fa-regular fa-calendar-plus',
                    label: Lang.get('portfolio.show.statistics.start-date'),
                    value: data.value.startedAt,
                },
                {
                    icon: 'fa-regular fa-calendar-check',
                    label: Lang.get('portfolio.show.statistics.finish-date'),
                    value: data.value.finishedAt || Lang.get('main.present'),
                },
            ]

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

<style>
html {
    scroll-padding-top: 65px;
}

.project-description ul {
    margin-left: 0;
}

.project-description li {
    list-style-position: inside;
}
</style>
