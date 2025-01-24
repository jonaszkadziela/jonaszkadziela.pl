<template>
    <DefaultLayout :dark-mode="darkMode"
                   :menu-data="menuData"
                   :social-data="socialData"
    >
        <RouterView :dark-mode="darkMode"
                    :menu-data="menuData"
                    :social-data="socialData"
        />
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from './layouts/DefaultLayout.vue'
import { getTranslation } from '../translation.js'
import { useToast } from 'primevue/usetoast'
import {
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const toast = useToast()

const darkMode = ref(false)
const menuData = ref([])
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

const mutationObserver = new MutationObserver(([ entry ]) => {
    if (entry.attributeName === 'class') {
        darkMode.value = entry.target.classList.contains('dark')
    }
})

onMounted(() => {
    darkMode.value = document.body.parentNode.classList.contains('dark')
    mutationObserver.observe(document.body.parentNode, { attributes: true })

    axios
        .get('/menus')
        .then(response => {
            if (!Array.isArray(response.data)) {
                return
            }

            menuData.value = response.data.map(menu => {
                return {
                    label: getTranslation(menu.translations, menu.name),
                    route: menu.route,
                }
            })
        })
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
        }))
})
onBeforeUnmount(() => {
    mutationObserver.disconnect()
})
</script>
