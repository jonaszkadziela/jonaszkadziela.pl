<template>
    <section id="leave-a-message"
             class="container flex flex-col items-center justify-center md:flex-row md:gap-24 md:min-h-[85vh] md:text-left mx-auto px-4 py-16 relative"
    >
        <div class="max-w-2xl mb-16 mx-auto text-center">
            <h1 class="font-bold mb-8 sm:text-6xl text-4xl">
                {{ Lang.get('contact.leave-a-message.title') }}
            </h1>
            <p class="dark:text-gray-300 mb-12 text-gray-600 text-lg">
                {{ Lang.get('contact.leave-a-message.description') }}
            </p>
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-8 md:flex-row">
                    <div class="flex flex-col gap-1 w-full">
                        <FloatLabel class="w-full"
                                    variant="on"
                        >
                            <InputText v-model="formData.name"
                                       :invalid="formErrors?.errors?.name"
                                       id="name"
                                       type="text"
                                       fluid
                            />
                            <label for="name">
                                {{ Lang.get('contact.form.name') }}
                            </label>
                        </FloatLabel>
                        <Message v-if="formErrors?.errors?.name"
                                 severity="error"
                                 size="small"
                                 variant="simple"
                        >
                            {{ formErrors?.errors?.name[0] }}
                        </Message>
                    </div>
                    <div class="flex flex-col gap-1 w-full">
                        <FloatLabel class="w-full"
                                    variant="on"
                        >
                            <InputText v-model="formData.email"
                                       :invalid="formErrors?.errors?.name"
                                       id="email"
                                       type="email"
                                       fluid
                            />
                            <label for="email">
                                {{ Lang.get('contact.form.email') }}
                            </label>
                        </FloatLabel>
                        <Message v-if="formErrors?.errors?.email"
                                 severity="error"
                                 size="small"
                                 variant="simple"
                        >
                            {{ formErrors?.errors?.email[0] }}
                        </Message>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <div class="flex flex-col gap-1 w-full">
                        <FloatLabel class="w-full"
                                    variant="on"
                        >
                            <Textarea v-model="formData.message"
                                      :invalid="formErrors?.errors?.message"
                                      id="message"
                                      rows="5"
                                      autoResize
                                      fluid
                            />
                            <label for="message">
                                {{ Lang.get('contact.form.message') }}
                            </label>
                        </FloatLabel>
                        <Message v-if="formErrors?.errors?.message"
                                 severity="error"
                                 size="small"
                                 variant="simple"
                        >
                            {{ formErrors?.errors?.message[0] }}
                        </Message>
                    </div>
                    <Button v-tooltip.left="{
                                value: Lang.get('contact.form.fill-out'),
                                disabled: !disabled,
                                class: 'min-w-fit',
                            }"
                            :disabled="disabled"
                            :class="disabled ? '' : 'hover:-translate-y-0.5 hover:shadow-xl'"
                            :label="loading ? `${Lang.get('contact.form.sending')}...` : Lang.get('contact.form.send-message')"
                            class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 md:min-w-36 md:ml-auto mt-4 to-blue-900 transition-all"
                            rounded
                            @click="sendMessage"
                    />
                </div>
            </div>
        </div>
        <Button :label="Lang.get('home.buttons.see-more')"
                as="a"
                class="-mb-6 absolute bg-blue-50 border-blue-50 bottom-0 dark:bg-blue-950 dark:border-blue-950 dark:hover:bg-blue-900 dark:text-blue-100 hover:bg-blue-100 text-blue-900"
                href="#get-in-touch"
                icon="fa fa-chevron-down"
                iconPos="right"
                severity="secondary"
                rounded
        />
    </section>
    <section id="get-in-touch"
             class="-mb-4 bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
    >
        <div class="container mx-auto px-4">
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold mb-4">
                    {{ Lang.get('contact.get-in-touch.title') }}
                </h3>
                <p class="dark:text-blue-200 text-blue-800">
                    {{ Lang.get('contact.get-in-touch.description') }}
                </p>
            </div>
            <div class="flex flex-wrap gap-8 justify-center">
                <Card :pt="{
                    body: 'text-center p-8',
                    root: 'dark:shadow-blue-800/80 duration-300 hover:shadow-xl md:w-[calc(50%-16px)] transition-shadow w-full',
                }">
                    <template #title>
                        <h4 class="font-semibold text-3xl">
                            {{ Lang.get('contact.get-in-touch.not-replying.title') }}
                        </h4>
                    </template>
                    <template #content>
                        <div class="my-4">
                            {{ Lang.get('contact.get-in-touch.not-replying.description') }}
                        </div>
                    </template>
                    <template #footer>
                        <a :href="Lang.get('contact.get-in-touch.not-replying.phone-link')"
                           class="duration-300 gap-4 group hover:text-blue-600 inline-flex items-center text-blue-500 text-lg transition-color"
                        >
                            <i class="fa fa-fw fa-lg fa-phone"></i>
                            <span class="group-hover:underline underline-offset-8">
                                {{ Lang.get('contact.get-in-touch.not-replying.phone-label') }}
                            </span>
                        </a>
                    </template>
                </Card>
                <Card :pt="{
                    body: 'text-center p-8',
                    root: 'dark:shadow-blue-800/80 duration-300 hover:shadow-xl md:w-[calc(50%-16px)] transition-shadow w-full',
                }">
                    <template #title>
                        <h4 class="font-semibold text-3xl">
                            {{ Lang.get('contact.get-in-touch.social-media.title') }}
                        </h4>
                    </template>
                    <template #content>
                        <div class="my-4">
                            {{ Lang.get('contact.get-in-touch.social-media.description') }}
                        </div>
                    </template>
                    <template #footer>
                        <div class="flex flex-wrap gap-4 justify-center text-blue-500 transition-color">
                            <a v-for="social in socialData"
                               v-tooltip.top="social.title"
                               :href="social.link"
                               :key="social.id"
                               class="border border-blue-500 dark:hover:text-black duration-300 flex hover:bg-blue-600 hover:border-blue-600 hover:text-white items-center justify-center rounded-full size-14"
                               target="_blank"

                            >
                                <i :class="social.icon"
                                   class="fa-fw fa-xl"
                                ></i>
                            </a>
                        </div>
                    </template>
                </Card>
            </div>
        </div>
    </section>
</template>

<script setup>
import {
    computed,
    ref,
} from 'vue'
import { useToast } from 'primevue/usetoast'

defineProps({
    darkMode: Boolean,
    menuData: Array,
    socialData: Array,
})

const toast = useToast()

const formData = ref({})
const formErrors = ref({})
const loading = ref(false)

const disabled = computed(() => !formCompleted.value || loading.value)
const formCompleted = computed(() => formData.value.name && formData.value.email && formData.value.message)

function sendMessage() {
    loading.value = true

    axios
        .post('/contact', formData.value)
        .then(() => {
            toast.add({
                severity: 'success',
                summary: Lang.get('toast.success.send-message.summary'),
                detail: Lang.get('toast.success.send-message.detail'),
                life: 10000,
            })

            formData.value = {}
            formErrors.value = {}
        })
        .catch(error => {
            toast.add({
                severity: 'error',
                summary: Lang.get('toast.error.send-message.summary'),
                detail: Lang.get('toast.error.send-message.detail'),
            })

            formErrors.value = error.response.data
        })
        .finally(() => loading.value = false)
}
</script>

<style>
html {
    scroll-padding-top: 65px;
}
</style>
