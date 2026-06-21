<template>
    <section class="container flex flex-col gap-12 items-center justify-center md:flex-row md:gap-24 md:min-h-[85vh] md:text-left mx-auto px-4 py-16 relative text-center">
        <div class="min-w-40 w-40">
            <img :src="Spaceship"
                 alt="Spaceship"
            >
            <img :src="Exhaust"
                 alt="Exhaust"
                 class="absolute animate-thrust w-40 z-[-1]"
            >
        </div>
        <div :class="maxWidthClass"
             class="flex flex-col md:order-first order-last"
        >
            <h1 class="font-bold mb-12 sm:text-6xl text-4xl">
                {{ translations.title }}!
            </h1>
            <p class="dark:text-gray-300 text-gray-600 text-lg">
                {{ translations.description1 }}.
            </p>
            <p class="dark:text-gray-300 text-gray-600 text-lg">
                {{ translations.description2 }}.
            </p>
            <div class="flex flex-col gap-4 justify-center md:flex-row md:justify-start mt-12">
                <Button :disabled="issueReported"
                        :label="issueReported ? translations.issueReported : translations.reportIssue"
                        severity="secondary"
                        rounded
                        @click="reportIssue"
                />
                <Button :label="translations.returnToHomePage"
                        as="RouterLink"
                        class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl to-blue-900 transition-all"
                        to="/"
                        rounded
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import Exhaust from '@/images/not-found-page/exhaust.png'
import Spaceship from '@/images/not-found-page/spaceship.png'
import { onBeforeRouteUpdate } from 'vue-router'
import { ref } from 'vue'
import { useToast } from 'primevue/usetoast'

defineProps({
    maxWidthClass: {
        type: String,
        default: 'max-w-2xl',
    },
    translations: {
        type: Object,
        default: () => ({
            description1: Lang.get('not-found.description-1'),
            description2: Lang.get('not-found.description-2'),
            issueReported: Lang.get('not-found.buttons.issue-reported'),
            reportIssue: Lang.get('not-found.buttons.report-issue'),
            returnToHomePage: Lang.get('not-found.buttons.return-to-home-page'),
            title: Lang.get('not-found.title'),
        }),
    },
})

const toast = useToast()
const issueReported = ref(false)
const timestamp = Date.now()

function reportIssue() {
    axios
        .post('/feedback', {
            type: 'issue',
            body: document.title,
            data: {
                _telescope: timestamp,
                url: window.location.href,
                userAgent: navigator.userAgent,
            },
        })
        .then(() => {
            toast.add({
                severity: 'success',
                summary: Lang.get('toast.success.report-issue.summary'),
                detail: Lang.get('toast.success.report-issue.detail'),
                life: 10000,
            })

            issueReported.value = true
        })
        .catch(() => {
            toast.add({
                severity: 'error',
                summary: Lang.get('toast.error.report-issue.summary'),
                detail: Lang.get('toast.error.report-issue.detail'),
            })
        })
}

onBeforeRouteUpdate(() => {
    issueReported.value = false
})
</script>

<style scoped>
.animate-thrust {
    animation: thrust 3s infinite;
}

@keyframes thrust {
    0%, 100% {
        opacity: 1;
        transform: translateY(-20%);
        animation-timing-function: linear;
    }
    50% {
        opacity: 0.5;
        transform: translateY(-15%);
        animation-timing-function: linear;
    }
}
</style>
