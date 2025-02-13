<template>
    <LoadingScreen :loading="loading" />
    <div v-if="!loading && data">
        <template v-for="(section, index) in data.sections"
                  :key="index"
        >
            <PageSection :section="section"
                         :translations="data.translations"
            />
        </template>
    </div>
</template>

<script setup>
import LoadingScreen from '../shared/LoadingScreen.vue'
import PageSection from '../sections/PageSection.vue'
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

onMounted(() => {
    axios
        .get('/json-pages/privacy')
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
html {
    scroll-padding-top: 65px;
}
</style>
