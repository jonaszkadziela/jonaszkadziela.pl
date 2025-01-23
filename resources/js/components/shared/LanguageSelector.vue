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
            ref="select"
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
const options = ref(null)
const select = ref(null)

function changeLanguage(event) {
    window.location.replace(`/language/${event.value}`)
}

onMounted(() => {
    const show = select.value.show
    const hide = select.value.hide

    // Fix bug that causes automatic scrolling when clicking on select dropdown
    select.value.show = () => show()
    select.value.hide = () => hide()

    axios.get('/language-options')
        .then(response => {
            options.value = response.data
        })
})
</script>
