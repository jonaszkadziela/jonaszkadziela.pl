<template>
    <Chart :data="data"
           :options="options"
           type="doughnut"
    />
</template>

<script setup>
import { getTranslation } from '../../translation.js'

const props = defineProps({
    section: Object,
    translations: Object,
})

const data = {
    datasets: props.section.data.datasets,
    labels: props.section.data.labels.map(label => getTranslation(props.translations, label))
}

const options = {
    ...props.section.data.options,
}
</script>
