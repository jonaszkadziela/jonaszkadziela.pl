<template>
    <section id="introduction"
             class="container flex flex-col gap-12 items-center justify-center md:flex-row md:gap-24 md:min-h-[85vh] md:py-0 md:text-left mx-auto px-4 py-16 relative text-center"
    >
        <div class="flex flex-col max-w-2xl md:order-first order-last">
            <h1 class="text-6xl font-bold mb-1">
                {{ Lang.get('home.introduction.title') }}
            </h1>
            <h2 class="mb-12 text-3xl">
                {{ Lang.get('home.introduction.subtitle') }}
            </h2>
            <p class="dark:text-gray-300 mb-12 text-gray-600 text-lg">
                {{ Lang.get('home.introduction.description') }}.
            </p>
            <div class="flex flex-col gap-4 justify-center md:flex-row md:justify-start">
                <Button :label="Lang.get('home.buttons.get-in-touch')"
                        as="RouterLink"
                        severity="secondary"
                        to="/contact"
                        rounded
                />
                <Button :label="Lang.get('home.buttons.view-portfolio')"
                        as="RouterLink"
                        class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl to-blue-900 transition-all"
                        to="/portfolio"
                        rounded
                />
            </div>
        </div>
        <img :alt="Lang.get('home.introduction.picture')"
             :src="FullBodyPicture"
             class="md:max-h-[50vh] md:h-auto lg:pt-8 lg:max-h-[85vh] h-64"
        >
        <SectionButton :label="Lang.get('main.buttons.see-more')"
                       as="a"
                       href="#featured-posts"
        />
    </section>
    <section id="featured-posts"
             class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
    >
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold mb-4">
                    {{ Lang.get('home.featured-posts.title') }}
                </h3>
                <p class="dark:text-blue-200 text-blue-800">
                    {{ Lang.get('home.featured-posts.description') }}.
                </p>
            </div>
            <div class="flex flex-wrap gap-8 justify-center">
                <PostCard v-for="post in blogData"
                          :key="post.slug"
                          :post="post"
                          class="md:w-[calc(50%-16px)]"
                />
                <PostCardSkeleton v-if="blogData === null"
                                  class="md:w-[calc(50%-16px)]"
                />
            </div>
            <div class="mt-8 text-center">
                <RouterLink class="hover:underline underline-offset-8"
                            to="/blog"
                >
                    {{ Lang.get('home.featured-posts.view-all') }}
                </RouterLink>
            </div>
        </div>
    </section>
    <section id="my-expertise"
             class="container mx-auto px-4 py-16"
    >
        <div class="max-w-2xl mb-16 mx-auto text-center">
            <h3 class="text-4xl font-bold mb-4">
                {{ Lang.get('home.my-expertise.title') }}
            </h3>
            <p class="dark:text-gray-300 mb-12 text-gray-600">
                {{ Lang.get('home.my-expertise.description') }}.
            </p>
        </div>
        <div class="gap-8 grid grid-cols-1 md:grid-cols-2">
            <RouterLink v-for="expertise in expertiseData"
                        :key="expertise.title"
                        :to="expertise.link"
                        class="border dark:shadow-blue-800/80 flex flex-row gap-6 group hover:shadow-xl p-6 relative rounded-xl transition-shadow"
            >
                <i :class="expertise.icon"
                   class="duration-300 group-hover:text-blue-700 text-4xl"
                ></i>
                <div class="flex flex-col gap-4">
                    <h4 class="duration-300 font-semibold group-hover:text-blue-700 text-2xl">
                        {{ expertise.title }}
                    </h4>
                    <p v-html="DOMPurify.sanitize(expertise.body)"
                       class="dark:text-gray-300 formatted-html text-gray-600"
                    ></p>
                </div>
                <div class="-translate-x-4 absolute duration-300 group-hover:opacity-100 group-hover:translate-x-0 opacity-0 right-5 text-2xl text-blue-700 top-5 transition-transform">
                    <i class="fa fa-arrow-right"></i>
                </div>
            </RouterLink>
        </div>
    </section>
    <section id="selected-projects"
             class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
    >
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold mb-4">
                    {{ Lang.get('home.selected-projects.title') }}
                </h3>
                <p class="dark:text-blue-200 text-blue-800">
                    {{ Lang.get('home.selected-projects.description') }}.
                </p>
            </div>
            <div class="gap-8 grid grid-cols-1">
                <ProjectCard v-for="project in projectData"
                             :key="project.slug"
                             :project="project"
                />
                <template v-if="projectData === null">
                    <ProjectCardSkeleton v-for="index in [...Array(3).keys()]"
                                         :key="index"
                    />
                </template>
            </div>
            <div class="mt-8 text-center">
                <RouterLink class="hover:underline underline-offset-8"
                            to="/portfolio"
                >
                    {{ Lang.get('home.selected-projects.view-all') }}
                </RouterLink>
            </div>
        </div>
    </section>
    <section id="my-achievements"
             class="container mx-auto px-4 py-16"
    >
        <div class="max-w-2xl mb-16 mx-auto text-center">
            <h3 class="text-4xl font-bold mb-4">
                {{ Lang.get('home.my-achievements.title') }}
            </h3>
            <p class="dark:text-gray-300 mb-12 text-gray-600">
                {{ Lang.get('home.my-achievements.description') }}.
            </p>
        </div>
        <div class="gap-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
            <DocumentCard v-for="document in documentData"
                          :document="document"
                          :key="document.slug"
                          class="border"
            />
            <template v-if="documentData === null">
                <DocumentCardSkeleton v-for="index in [...Array(8).keys()]"
                                      :key="index"
                                      class="border"
                />
            </template>
        </div>
        <div class="mt-8 text-center">
            <RouterLink class="hover:underline underline-offset-8"
                        to="/documents"
            >
                {{ Lang.get('home.my-achievements.view-all') }}
            </RouterLink>
        </div>
    </section>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useToast } from 'primevue/usetoast'
import DocumentCard from '../shared/DocumentCard.vue'
import DocumentCardSkeleton from '../skeletons/DocumentCardSkeleton.vue'
import DOMPurify from 'dompurify'
import FullBodyPicture from '@/images/pictures/fullbody-picture.png'
import PostCard from '../shared/PostCard.vue'
import PostCardSkeleton from '../skeletons/PostCardSkeleton.vue'
import ProjectCard from '../shared/ProjectCard.vue'
import ProjectCardSkeleton from '../skeletons/ProjectCardSkeleton.vue'
import SectionButton from '../shared/SectionButton.vue'

defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})

const toast = useToast()

const blogData = ref(null)
const documentData = ref(null)
const projectData = ref(null)
const expertiseData = [
    {
        title: Lang.get('home.expertise.programming.title'),
        body: Lang.get('home.expertise.programming.body'),
        link: '/cv#expertise',
        icon: 'fa fa-code',
    },
    {
        title: Lang.get('home.expertise.graphics-design.title'),
        body: Lang.get('home.expertise.graphics-design.body'),
        link: '/cv#expertise',
        icon: 'fa fa-paintbrush',
    },
    {
        title: Lang.get('home.expertise.system-administration.title'),
        body: Lang.get('home.expertise.system-administration.body'),
        link: '/cv#expertise',
        icon: 'fa fa-server',
    },
    {
        title: Lang.get('home.expertise.more.title'),
        body: Lang.get('home.expertise.more.body'),
        link: '/cv#expertise',
        icon: 'fa fa-wand-magic-sparkles',
    },
]

function getBlogData() {
    return axios
        .get('/posts', {
            params: {
                tags: ['featured'],
            },
        })
        .then(response => blogData.value = response.data.data)
}

function getProjectData() {
    return axios
        .get('/projects', {
            params: {
                tags: ['featured'],
            },
        })
        .then(response => projectData.value = response.data.data)
}

function getDocumentData() {
    return axios
        .get('/documents', {
            params: {
                tags: ['featured'],
            },
        })
        .then(response => documentData.value = response.data.data)
}

onMounted(() => {
    Promise
        .allSettled([
            getBlogData(),
            getProjectData(),
            getDocumentData(),
        ])
        .then(results => {
            const errors = results.filter(result => result.status === 'rejected')

            if (errors.length > 0) {
                toast.add({
                    severity: 'error',
                    summary: Lang.get('toast.error.load-data.summary'),
                    detail: Lang.get('toast.error.load-data.detail'),
                })
            }
        })
})
</script>
