<template>
    <Select v-model="currentLanguage"
            :options="options"
            :pt="{
                label: 'pr-0',
                overlay: '!left-auto end-0'
            }"
            appendTo="self"
            optionLabel="label"
            optionValue="value"
            checkmark
            @change="changeLanguage"
    >
        <template #value>
            <slot />
        </template>
    </Select>
</template>

<script setup>
import {
    onMounted,
    ref,
} from 'vue'

const currentLanguage = ref(Lang.locale)
const options = ref()

function changeLanguage(event) {
    window.location.replace(`/language/${event.value}`)
}

onMounted(() => {
    axios.get('/language-options')
        .then(response => {
            options.value = response.data
        })
})
</script>
