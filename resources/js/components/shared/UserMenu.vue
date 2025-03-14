<template>
    <Select :options="options"
            :pt="{
                label: 'pr-0',
                overlay: '!left-auto end-0 min-w-max'
            }"
            appendTo="self"
            optionLabel="label"
            optionValue="value"
            @change="changeUserMenu"
    >
        <template #header>
            <div class="border-b cursor-default dark:border-gray-600 font-semibold p-4">
                <i class="fa-solid fa-circle-user mr-2"></i>
                <span>
                    {{ userStore.currentUser.name }}
                </span>
            </div>
        </template>
        <template #value>
            <i class="fa-solid fa-user"></i>
        </template>
        <template #footer>
            <div class="border-t dark:border-gray-600">
                <slot />
            </div>
        </template>
    </Select>
</template>

<script setup>
import { userStore } from '../../store/user.js'
import { useToast } from 'primevue/usetoast'
import { ref } from 'vue'

const toast = useToast()

const options = ref([
    {
        label: Lang.get('main.user-menu.admin'),
        value: '/admin',
    },
    {
        label: Lang.get('main.user-menu.logout'),
        value: '/admin/logout',
    },
])

function changeUserMenu(event) {
    switch (event.value) {
        case '/admin/logout':
            axios.post(`${location.origin}/admin/logout`)
                .then(() => {
                    toast.add({
                        severity: 'success',
                        summary: Lang.get('toast.success.log-out.summary'),
                        detail: Lang.get('toast.success.log-out.detail'),
                        life: 10000,
                    })

                    userStore.currentUser = {}
                })
            break;

        default:
            window.location.assign(event.value)
            break;
    }
}
</script>
