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
            <div class="border-b cursor-default dark:border-gray-600 p-4 select-text">
                <p class="font-semibold">
                    {{ userStore.currentUser.name }}
                </p>
                <p class="dark:text-gray-300 text-gray-600">
                    {{ userStore.currentUser.email }}
                </p>
            </div>
        </template>
        <template #value>
            <img v-if="userStore.currentUser.avatar"
                 :src="userStore.currentUser.avatar"
                 alt="Avatar"
                 class="size-6 rounded-full min-w-6 border"
            >
            <i v-else
               class="fa-solid fa-user"
            ></i>
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
