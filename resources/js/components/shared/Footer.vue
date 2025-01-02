<template>
    <footer class="bg-white border-t dark:bg-black dark:border-none">
        <div class="container dark:text-gray-300 mx-auto px-4 py-16 text-gray-600">
            <div class="gap-8 grid grid-cols-3 justify-items-center mb-12 md:grid-cols-6 mx-auto w-1/2">
                <a v-for="social in socialData"
                   :href="social.link"
                   :key="social.id"
                   class="duration-300 hover:text-blue-600 text-3xl text-blue-500 transition-color"
                   target="_blank"
                >
                    <i v-tooltip.top="social.title"
                       :class="social.icon"
                    ></i>
                </a>
            </div>
            <div class="flex flex-col gap-4 items-center justify-center mb-12 md:flex-row md:gap-8">
                <RouterLink v-for="item in menuItems"
                            :key="item.label"
                            :to="item.route"
                            class="hover:underline underline-offset-8"
                >
                    {{ item.label }}
                </RouterLink>
            </div>
            <div class="flex justify-center mb-12 md:hidden">
                <LanguageSelector>
                    <i class="fa fa-earth-europe mr-1"></i>
                    {{ Lang.get('main.footer.language') }}
                </LanguageSelector>
            </div>
            <div class="text-center">
                {{ Lang.get('main.footer.programmed-with') }}
                <i class="fa-solid fa-heart text-blue-500"></i>
                {{ Lang.get('main.footer.by') }}
                <a class="duration-300 hover:text-blue-600 hover:underline text-blue-500 transition-color underline-offset-8"
                   href="https://jonaszkadziela.pl"
                   target="_blank"
                >
                    {{ Lang.get('main.footer.author') }}
                </a>
            </div>
        </div>
    </footer>
</template>

<script setup>
import LanguageSelector from './LanguageSelector.vue'
import { ref } from 'vue'

const socialData = [
    {
        id: 1,
        title: 'Facebook',
        link: 'https://facebook.com/jonaszkadzielapl',
        icon: 'fa-brands fa-facebook-f',
    },
    {
        id: 2,
        title: 'LinkedIn',
        link: 'https://linkedin.com/in/jonaszkadziela',
        icon: 'fa-brands fa-linkedin-in',
    },
    {
        id: 3,
        title: 'X (Twitter)',
        link: 'https://x.com/jonaszkadziela',
        icon: 'fa-brands fa-x-twitter',
    },
    {
        id: 4,
        title: 'YouTube',
        link: 'https://youtube.com/jonaszkadziela',
        icon: 'fa-brands fa-youtube',
    },
    {
        id: 5,
        title: 'GitHub',
        link: 'https://github.com/jonaszkadziela',
        icon: 'fa-brands fa-github',
    },
    {
        id: 6,
        title: 'Stack Overflow',
        link: 'https://stackoverflow.com/users/9310738/jonasz-kadziela',
        icon: 'fa-brands fa-stack-overflow',
    },
]

const menuItems = ref([
    {
        label: 'Home',
        route: '/',
    },
    {
        label: 'Meet me',
        route: '/meet-me',
    },
    {
        label: 'CV',
        route: '/cv',
    },
    {
        label: 'Portfolio',
        route: '/portfolio',
    },
    {
        label: 'Contact',
        route: '/contact',
    },
])
</script>
