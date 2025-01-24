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
        <div class="flex flex-col max-w-2xl md:order-first order-last">
            <h1 class="font-bold mb-12 sm:text-6xl text-4xl">
                {{ Lang.get('not-found.title') }}!
            </h1>
            <p class="dark:text-gray-300 text-gray-600 text-lg">
                {{ Lang.get('not-found.description-1') }}.
            </p>
            <p class="dark:text-gray-300 text-gray-600 text-lg">
                {{ Lang.get('not-found.description-2') }}.
            </p>
            <div class="flex flex-col gap-4 justify-center md:flex-row md:justify-start mt-12">
                <Button :disabled="issueReported"
                        :label="issueReported ? Lang.get('not-found.buttons.issue-reported') : Lang.get('not-found.buttons.report-issue')"
                        severity="secondary"
                        rounded
                        @click="reportIssue"
                />
                <Button :label="Lang.get('not-found.buttons.return-to-home-page')"
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
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
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
