<template>
    <Dialog v-model:visible="visible"
            :header="Lang.get('dialog.feedback.header')"
            :pt="{
                header: 'cursor-grab',
            }"
            modal
            @hide="closeDialog"
    >
        <span class="text-surface-500 dark:text-surface-400 block mb-8">
            {{ Lang.get('dialog.feedback.message') }}
        </span>
        <div class="flex flex-col gap-1 mb-4 w-full">
            <div class="flex flex-col-reverse gap-4 items-center md:flex-row">
                <SelectButton v-model="formData.type"
                              :invalid="Boolean(formErrors?.errors?.type)"
                              :options="options"
                              :size="selectButtonSize"
                              id="type"
                              optionLabel="label"
                              optionValue="value"
                >
                    <template #option="{ option }">
                        <i :class="option.icon"></i>
                        <span>
                            {{ option.label }}
                        </span>
                    </template>
                </SelectButton>
                <label v-if="!formData.type"
                       for="type"
                >
                    {{ Lang.get('dialog.feedback.choose-type') }}
                </label>
            </div>
            <Message v-if="formErrors?.errors?.type"
                     severity="error"
                     size="small"
                     variant="simple"
            >
                {{ formErrors?.errors?.type[0] }}
            </Message>
        </div>
        <div class="flex flex-col gap-1 mb-4 w-full">
            <FloatLabel class="w-full"
                        variant="on"
            >
                <Textarea v-model="formData.body"
                          :invalid="Boolean(formErrors?.errors?.body)"
                          id="body"
                          rows="5"
                          autoResize
                          fluid
                />
                <label for="body">
                    {{ Lang.get('dialog.feedback.body') }}
                </label>
            </FloatLabel>
            <Message v-if="formErrors?.errors?.body"
                     severity="error"
                     size="small"
                     variant="simple"
            >
                {{ formErrors?.errors?.body[0] }}
            </Message>
        </div>
        <div class="flex justify-end gap-2">
            <Button :label="Lang.get('dialog.feedback.cancel')"
                    type="button"
                    severity="secondary"
                    @click="closeDialog"
            />
            <Button :label="Lang.get('dialog.feedback.save')"
                    type="button"
                    @click="sendFeedback"
            />
        </div>
    </Dialog>
</template>

<script setup>
import { breakpointsTailwind, useBreakpoints } from '@vueuse/core'
import { computed, ref } from 'vue'
import { useToast } from 'primevue/usetoast'

const emit = defineEmits([
    'closed',
    'saved',
])

const breakpoints = useBreakpoints(breakpointsTailwind)
const toast = useToast()

const formData = ref({})
const formErrors = ref({})
const loading = ref(false)
const timestamp = Date.now()
const visible = ref(true)

const options = ref([
    {
        icon: 'fa-solid fa-circle-exclamation',
        label: Lang.get('dialog.feedback.types.issue'),
        value: 'issue',
    },
    {
        icon: 'fa-solid fa-medal',
        label: Lang.get('dialog.feedback.types.praise'),
        value: 'praise',
    },
    {
        icon: 'fa-solid fa-lightbulb',
        label: Lang.get('dialog.feedback.types.suggestion'),
        value: 'suggestion',
    }
])

const selectButtonSize = computed(() => breakpoints.greater('md').value ? 'medium' : 'small')

function closeDialog() {
    emit('closed')
}

function sendFeedback() {
    axios
        .post('/feedback', {
            ...formData.value,
            data: {
                _telescope: timestamp,
                url: window.location.href,
                userAgent: navigator.userAgent,
            },
        })
        .then(() => {
            toast.add({
                severity: 'success',
                summary: Lang.get('toast.success.send-feedback.summary'),
                detail: Lang.get('toast.success.send-feedback.detail'),
                life: 10000,
            })

            formData.value = {}
            formErrors.value = {}

            emit('saved')
        })
        .catch(error => {
            toast.add({
                severity: 'error',
                summary: Lang.get('toast.error.send-feedback.summary'),
                detail: Lang.get('toast.error.send-feedback.detail'),
            })

            formErrors.value = error.response.data
        })
        .finally(() => loading.value = false)
}
</script>
