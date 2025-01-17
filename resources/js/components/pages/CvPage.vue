<template>
    <transition leave-active-class="delay-300 duration-300 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
    >
        <div v-if="loading"
             class="bg-white dark:bg-black fixed flex inset-0 items-center justify-center z-40"
        >
            <span class="animate-fade-in">
                {{ Lang.get('main.loading') }}...
            </span>
        </div>
    </transition>
    <div id="header"></div>
    <div id="body"
         class="cv-body cv-width mx-auto p-12"
    >
        <div class="flex gap-8">
            <div id="left-side"
                 class="flex flex-col gap-8 w-1/3"
            ></div>
            <div id="right-side"
                 class="flex flex-col gap-8 w-2/3"
            ></div>
        </div>
    </div>
    <div id="footer"></div>
    <div v-if="!loading && data">
        <template v-for="(section, index) in data.sections"
                  :key="index"
        >
            <Teleport :to="section.teleport">
                <CvSection :section="section"
                           :translations="data.translations"
                />
            </Teleport>
        </template>
        <Teleport to="#left-side">
            <p class="dark:text-gray-300 italic text-gray-600">
                {{ Lang.get('main.last-update') }}: {{ data.updatedAt }}
            </p>
        </Teleport>
    </div>
</template>

<script setup>
import CvSection from '../sections/CvSection.vue'
import {
    onMounted,
    ref,
} from 'vue'
import { useToast } from 'primevue/usetoast'

const toast = useToast()

const data = ref(null)
const loading = ref(true)

onMounted(() => {
    axios
        .get('/json-page/cv')
        .then(response => data.value = response.data)
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('main.errors.load-data.summary'),
            detail: Lang.get('main.errors.load-data.detail'),
        }))
        .finally(() => loading.value = false)
})
</script>

<style>
body {
    min-width: 72rem !important;
    max-width: 100% !important;
}

.cv-width {
    max-width: 72rem;
    min-width: 72rem;
    width: 72rem;
}

.cv-body ul {
    margin-left: 1rem;
}

.cv-body li {
    list-style-type: disc;
}

.cv-body small {
    display: block;
    font-size: 0.9rem;
}

.cv-body section {
    page-break-inside: avoid;
}

@media print {
    footer,
    nav {
        display: none;
    }
}

@page {
    size: A4;
    margin: 0;

    @bottom-right {
        background: linear-gradient(to right bottom, #2563eb, #1e3a8a);
        color: #ffffff;
        content: 'Page ' counter(page) '/' counter(pages);
        height: 32px;
        margin-top: -48px !important;
        padding: 0 8px;
        text-align: center;
        width: 72px;
    }
}
</style>
