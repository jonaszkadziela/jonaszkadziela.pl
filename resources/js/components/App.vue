<template>
    <DefaultLayout :dark-mode="darkMode"
                   :menu-data="menuData"
    >
        <RouterView />
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from './layouts/DefaultLayout.vue'
import { getTranslation } from '../translation.js'
import { useRouter } from 'vue-router'
import { useToast } from 'primevue/usetoast'
import {
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const router = useRouter()
const toast = useToast()

const darkMode = ref(false)
const menuData = ref([])

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
                    command: ({ item }) => router.push(item.route),
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
