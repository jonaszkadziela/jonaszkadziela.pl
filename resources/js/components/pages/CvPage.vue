<template>
    <LoadingScreen :loading="loading" />
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
    <SpeedDial :model="actions"
               class="bottom-5 fixed right-5"
               direction="up"
               id="actions-button"
    >
        <template #button="{ toggleCallback }">
            <Button class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl size-12 to-blue-900 transition-all"
                    rounded
                    @click="toggleCallback"
            >
                <i class="fa fa-ellipsis-vertical"></i>
            </Button>
        </template>
        <template #item="{ item, toggleCallback }">
            <div v-tooltip.left="item.label"
                 class="bg-white border cursor-pointer dark:bg-black flex items-center justify-center rounded-full size-12"
                 @click="toggleCallback"
            >
                <i :class="item.icon"></i>
            </div>
        </template>
    </SpeedDial>
</template>

<script setup>
import CvSection from '../sections/CvSection.vue'
import LoadingScreen from '../shared/LoadingScreen.vue'
import {
    onMounted,
    ref,
} from 'vue'
import { useToast } from 'primevue/usetoast'

defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})

const toast = useToast()

const data = ref(null)
const loading = ref(true)

const actions = ref([
    {
        label: Lang.get('main.print'),
        icon: 'fa fa-print',
        command: () => {
            window.print()
        },
    },
    {
        label: Lang.get('main.share'),
        icon: 'fa fa-link',
        command: () => {
            const link = location.href

            try {
                navigator.clipboard.writeText(link)
                    .then(() => toast.add({
                        severity: 'success',
                        summary: Lang.get('toast.success.copy-link.summary'),
                        detail: Lang.get('toast.success.copy-link.detail', { link }),
                        life: 3000,
                    }))
            } catch {
                toast.add({
                    severity: 'error',
                    summary: Lang.get('toast.error.copy-link.summary'),
                    detail: Lang.get('toast.error.copy-link.detail'),
                })
            }
        },
    },
])

onMounted(() => {
    axios
        .get('/json-pages/cv')
        .then(response => data.value = response.data.data)
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
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
    #actions-button,
    footer,
    nav {
        display: none;
    }

    #footer {
        position: fixed !important;
        bottom: 0;
        left: 0;
        right: 0;
        margin-bottom: 1rem;
    }
}

@page {
    size: A4;
    margin: 20px 0;

    @bottom-right {
        background: linear-gradient(to right bottom, #2563eb, #1e3a8a);
        color: #ffffff;
        content: counter(page) '/' counter(pages);
        height: 32px;
        margin-top: -110px !important;
        margin-right: 16px;
        padding: 0 8px;
        text-align: center;
        width: 32px;
    }
}
</style>
