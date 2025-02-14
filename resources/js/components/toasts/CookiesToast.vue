<template>
    <Toast class="max-w-72 md:max-w-full"
           group="cookies"
           position="bottom-right"
    >
        <template #message="slotProps">
            <div class="-m-4 bg-white border dark:bg-zinc-900 dark:text-gray-300 duration-500 flex flex-col gap-4 hover:opacity-100 hover:shadow-xl opacity-80 p-4 rounded-lg shadow-md transition-all">
                <div class="text-sm">
                    {{ slotProps.message.summary }}
                    <a href="/privacy"
                       class="duration-300 hover:text-blue-600 hover:underline text-blue-500 transition-color underline-offset-[6px]"
                    >
                        {{ Lang.get('toast.cookies.privacy-policy') }}.
                    </a>
                </div>
                <div class="border-t border-gray-300 dark:border-gray-600"></div>
                <div class="flex flex-col gap-2 md:flex-row md:justify-end">
                    <Button :label="Lang.get('toast.cookies.learn-more')"
                            as="RouterLink"
                            to="/privacy"
                            variant="text"
                            rounded
                    />
                    <Button :label="Lang.get('toast.cookies.acknowledge')"
                            class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl to-blue-900 transition-all"
                            rounded
                            @click="onAcknowledge"
                    />
                </div>
            </div>
        </template>
    </Toast>
</template>

<script setup>
import { useToast } from 'primevue/usetoast'
import { onMounted } from 'vue'

const toast = useToast()

function showTemplate() {
    toast.add({
        closable: false,
        group: 'cookies',
        severity: 'other',
        summary: Lang.get('toast.cookies.description'),
    })
}

function onAcknowledge() {
    localStorage.setItem('privacy-warning-dismissed', 'true')

    toast.removeGroup('cookies')
}

onMounted(() => {
    let dismissed = localStorage.getItem('privacy-warning-dismissed')

    if (dismissed !== 'true') {
        setTimeout(() => showTemplate(), 250)
    }
})
</script>
