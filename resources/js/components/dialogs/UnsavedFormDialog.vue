<template>
    <ConfirmDialog />
</template>

<script setup>
import { useConfirm } from 'primevue/useconfirm'
import { onMounted } from 'vue'

const emit = defineEmits([
    'accepted',
    'closed',
    'rejected',
])

const props = defineProps({
    position: String,
})

const confirm = useConfirm()

function showUnsavedFormDialog() {
    confirm.require({
        header: Lang.get('dialog.unsaved-form.header'),
        message: Lang.get('dialog.unsaved-form.message'),
        icon: 'fa-solid fa-triangle-exclamation',
        position: props.position,
        acceptProps: {
            label: Lang.get('dialog.unsaved-form.accept'),
        },
        rejectProps: {
            label: Lang.get('dialog.unsaved-form.reject'),
            severity: 'secondary',
        },
        accept: () => emit('accepted'),
        reject: () => emit('rejected'),
        onHide: () => emit('closed'),
    })
}

onMounted(() => showUnsavedFormDialog())
</script>
