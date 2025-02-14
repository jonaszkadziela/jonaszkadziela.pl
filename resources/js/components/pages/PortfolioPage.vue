<template>
    <LoadingScreen :loading="loading" />
    <template v-if="!loading && projectData">
        <section id="latest-project"
                 class="container flex flex-col gap-16 items-center latest-project md:min-h-[85vh] mx-auto px-4 py-16 relative"
        >
            <div class="max-w-2xl mx-auto text-center">
                <h1 class="font-bold mb-8 sm:text-6xl text-4xl">
                    {{ Lang.get('portfolio.latest-project.title') }}
                </h1>
                <p class="dark:text-gray-300 text-gray-600 text-lg">
                    {{ Lang.get('portfolio.latest-project.description') }}
                </p>
            </div>
            <div v-if="latestProject"
                 class="flex flex-col gap-12 items-center max-w-6xl md:flex-row md:text-left text-center"
            >
                <div class="flex flex-col md:w-2/3 md:order-first order-last">
                    <h2 class="font-bold mb-12 sm:text-5xl text-4xl">
                        {{ getTranslation(latestProject.translations, latestProject.title) }}
                    </h2>
                    <div v-html="DOMPurify.sanitize(getTranslation(latestProject.translations, latestProject.body))"
                         class="dark:text-gray-300 formatted-html mb-12 text-gray-600 text-lg"
                    ></div>
                    <div class="flex flex-col gap-4 justify-center md:flex-row md:justify-start">
                        <Button v-if="latestProject.link"
                                :href="latestProject.link"
                                :label="Lang.get('main.buttons.project-page')"
                                as="a"
                                icon="fa-solid fa-up-right-from-square"
                                iconPos="right"
                                severity="secondary"
                                target="_blank"
                                rounded
                        />
                        <Button :label="Lang.get('portfolio.buttons.see-details')"
                                :to="latestProject.route"
                                as="RouterLink"
                                class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl to-blue-900 transition-all"
                                rounded
                        />
                    </div>
                </div>
                <div class="md:w-1/3">
                    <img :src="latestProject.image"
                         :alt="Lang.get('portfolio.latest-project.title')"
                         class="max-h-[500px]"
                    >
                </div>
            </div>
            <Button :label="Lang.get('main.buttons.see-more')"
                    as="a"
                    class="-mb-6 absolute bg-blue-50 border-blue-50 bottom-0 dark:bg-blue-950 dark:border-blue-950 dark:hover:bg-blue-900 dark:text-blue-100 hover:bg-blue-100 text-blue-900"
                    href="#other-works"
                    icon="fa fa-chevron-down"
                    iconPos="right"
                    severity="secondary"
                    rounded
            />
        </section>
        <section id="other-works"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
        >
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mb-16 mx-auto text-center">
                    <h3 class="text-4xl font-bold mb-4">
                        {{ Lang.get('portfolio.other-works.title') }}
                    </h3>
                    <p class="dark:text-blue-200 text-blue-800">
                        {{ Lang.get('portfolio.other-works.description') }}
                    </p>
                </div>
                <div class="grid grid-cols-1 gap-8">
                    <ProjectCard v-for="project in projectData"
                                 :key="project.slug"
                                 :project="project"
                    />
                </div>
            </div>
        </section>
    </template>
</template>

<script setup>
import DOMPurify from 'dompurify'
import LoadingScreen from '../shared/LoadingScreen.vue'
import ProjectCard from '../shared/ProjectCard.vue'
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

const latestProject = ref(null)
const loading = ref(true)
const projectData = ref(null)

onMounted(() => {
    axios
        .get('/projects')
        .then(response => {
            projectData.value = response.data.data
            latestProject.value = projectData.value.shift()
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
@media (max-width: 768px) {
    .latest-project ul {
        margin-left: 0;
    }

    .latest-project li {
        list-style-position: inside;
    }
}
</style>
