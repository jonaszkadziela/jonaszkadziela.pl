<template>
    <nav :class="navBarSticky ? 'backdrop-blur-md bg-white/75 dark:bg-black/75 dark:shadow-slate-800 shadow-lg transition-shadow' : 'dark:bg-black bg-white'"
         class="sticky top-[-1px] z-50"
         ref="navBar"
    >
        <Menubar :model="items"
                 :pt="{
                     button: 'flex md:hidden ml-auto p-2',
                     itemContent: 'container md:m-0 mx-auto my-1',
                     itemLabel: ({ context }) => [{
                         'cursor-pointer dark:text-gray-300 hover:underline text-gray-600 underline-offset-8': true,
                         'font-bold': context.item.route === $route.path,
                         'underline': context.focused,
                     }],
                     root: 'container delay-100 duration-300 flex gap-4 items-center mx-auto py-4',
                     rootList: ({ props }) => [{
                         'gap-6 md:flex md:mr-2 md:py-2 ml-auto': true,
                         'absolute border-t dark:border-gray-600 left-0 p-4 right-0 top-full': props.mobileActive,
                         'hidden': !props.mobileActive,
                         'bg-white/90 dark:bg-black/90': props.mobileActive && navBarSticky,
                         'dark:bg-black bg-white': props.mobileActive && !navBarSticky,
                     }],
                 }"
                 breakpoint="768px"
                 unstyled
        >
            <template #start>
                <a href="/"
                   class="flex items-center"
                >
                    <img :src="logo"
                         alt="Logo"
                         class="w-12 mr-2"
                    >
                    <span class="font-semibold">
                        Jonasz Kądziela
                    </span>
                </a>
            </template>
        </Menubar>
    </nav>
</template>

<script setup>
import LogoBlack from '@/images/brand/logo-black.svg'
import LogoWhite from '@/images/brand/logo-white.svg'
import { useRouter } from 'vue-router'
import {
    computed,
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const props = defineProps(['darkMode'])
const router = useRouter()

const navBar = ref(null)
const navBarSticky = ref(false)
const items = ref([
    {
        label: 'Home',
        route: '/',
        command: ({ item }) => router.push(item.route),
    },
    {
        label: 'Meet me',
        route: '/meet-me',
        command: ({ item }) => router.push(item.route),
    },
    {
        label: 'CV',
        route: '/cv',
        command: ({ item }) => router.push(item.route),
    },
    {
        label: 'Portfolio',
        route: '/portfolio',
        command: ({ item }) => router.push(item.route),
    },
    {
        label: 'Contact',
        route: '/contact',
        command: ({ item }) => router.push(item.route),
    },
])

const logo = computed(() => props.darkMode ? LogoWhite : LogoBlack)

const intersectionObserver = new IntersectionObserver(
    ([ entry ]) => navBarSticky.value = entry.intersectionRatio < 1,
    { threshold: [1] },
)

onMounted(() => {
    intersectionObserver.observe(navBar.value)
})
onBeforeUnmount(() => {
    intersectionObserver.disconnect()
})
</script>

<style>
html {
    scroll-padding-top: 70px;
}
</style>
