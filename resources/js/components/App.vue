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
import { appStore } from '../store/app.js'
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
const socialData = ref(null)

const mutationObserver = new MutationObserver(([ entry ]) => {
    if (entry.attributeName === 'class') {
        darkMode.value = entry.target.classList.contains('dark')
    }
})

function getCurrentUser() {
    return axios
        .get(`${location.origin}/users/current`)
        .then(response => userStore.currentUser = response.data)
}

function getOptionalFeatures() {
    return axios.get('/optional-features')
        .then(response => appStore.optionalFeatures = response.data)
}

function getMenuData() {
    return axios
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
}

function getSocialData() {
    return axios
        .get('/socials')
        .then(response => socialData.value = response.data.data)
}

onMounted(() => {
    darkMode.value = document.body.parentNode.classList.contains('dark')
    mutationObserver.observe(document.body.parentNode, { attributes: true })

    Promise
        .allSettled([
            getCurrentUser(),
            getMenuData(),
            getSocialData(),
            getOptionalFeatures(),
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
onBeforeUnmount(() => {
    mutationObserver.disconnect()
})
</script>
