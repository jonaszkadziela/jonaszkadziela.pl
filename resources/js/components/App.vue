<template>
    <DefaultLayout :dark-mode="darkMode"
                   :menu-data="menuData"
                   :social-data="socialData"
    >
        <RouterView :dark-mode="darkMode"
                    :menu-data="menuData"
                    :social-data="socialData"
        />
        <CookiesToast />
    </DefaultLayout>
</template>

<script setup>
import CookiesToast from './toasts/CookiesToast.vue'
import DefaultLayout from './layouts/DefaultLayout.vue'
import { getTranslation } from '../translation.js'
import { userStore } from '../store/user.js'
import { useToast } from 'primevue/usetoast'
import {
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const toast = useToast()

const darkMode = ref(false)
const menuData = ref([])
const socialData = ref([])

const mutationObserver = new MutationObserver(([ entry ]) => {
    if (entry.attributeName === 'class') {
        darkMode.value = entry.target.classList.contains('dark')
    }
})

onMounted(() => {
    darkMode.value = document.body.parentNode.classList.contains('dark')
    mutationObserver.observe(document.body.parentNode, { attributes: true })

    axios
        .get(`${location.origin}/users/current`)
        .then(response => userStore.currentUser = response.data)
        .catch(() => toast.add({
            severity: 'error',
            summary: Lang.get('toast.error.load-data.summary'),
            detail: Lang.get('toast.error.load-data.detail'),
        }))

    axios
        .get('/menus')
        .then(response => {
            if (!Array.isArray(response.data.data)) {
                return
            }

            menuData.value = response.data.data.map(menu => {
                return {
                    ...menu,
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

    axios
        .get('/socials')
        .then(response => socialData.value = response.data.data)
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
