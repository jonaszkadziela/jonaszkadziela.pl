<template>
    <nav :class="navBarSticky ? 'backdrop-blur-md bg-white/75 dark:bg-black/75 dark:shadow-slate-800 shadow-lg transition-shadow' : 'dark:bg-black bg-white'"
         class="select-none sticky top-[-1px] z-50"
         ref="navBar"
    >
        <Menubar :model="filteredMenuData"
                 :pt="{
                     button: 'flex md:hidden mr-2 order-2 p-2',
                     end: 'flex gap-2 md:ml-0 ml-auto mr-2',
                     itemContent: 'container md:m-0 mx-auto my-1',
                     itemLabel: ({ context }) => [{
                         'cursor-pointer dark:text-gray-300 hover:underline text-gray-600 underline-offset-8': true,
                         'font-bold': context.item.route === $route.path,
                         'underline': context.focused,
                     }],
                     root: 'container delay-100 duration-300 flex gap-0 items-center md:gap-4 mx-auto py-4',
                     rootList: ({ props }) => [{
                         'gap-6 md:flex md:mr-2 md:py-2 ml-auto': true,
                         'absolute border-t dark:border-gray-600 left-0 p-4 right-0 top-full': props.mobileActive,
                         'hidden': !props.mobileActive,
                         'bg-white/90 dark:bg-black/90': props.mobileActive && navBarSticky,
                         'dark:bg-black bg-white': props.mobileActive && !navBarSticky,
                     }],
                 }"
                 breakpoint="768px"
                 ref="menubar"
                 unstyled
        >
            <template #start>
                <RouterLink to="/"
                            class="flex items-center"
                >
                    <img :src="logo"
                         alt="Logo"
                         class="w-12 mr-2"
                    >
                    <span class="font-semibold">
                        {{ Lang.get('main.navbar.header') }}
                    </span>
                </RouterLink>
            </template>
            <template #item="{ props, item }">
                <RouterLink v-bind="props.action"
                            :to="item.route"
                >
                    <span v-bind="props.label">
                        {{ item.label }}
                    </span>
                </RouterLink>
            </template>
            <template #end>
                <DarkModeButton :dark-mode="darkMode"
                                class="bg-white border border-zinc-300 dark:bg-zinc-950 dark:border-zinc-600"
                                severity="secondary"
                />
                <UserMenu v-if="Object.keys(userStore.currentUser).length > 0">
                    <LanguageSelector class="border-none px-2 py-1 shadow-none w-full">
                        <i class="fa fa-earth-europe"></i>
                    </LanguageSelector>
                </UserMenu>
                <LanguageSelector v-else>
                    <i class="fa fa-earth-europe"></i>
                </LanguageSelector>
            </template>
        </Menubar>
    </nav>
</template>

<script setup>
import DarkModeButton from './DarkModeButton.vue'
import LanguageSelector from './LanguageSelector.vue'
import LogoBlack from '@/images/brand/logo-black.svg'
import LogoWhite from '@/images/brand/logo-white.svg'
import UserMenu from './UserMenu.vue'
import { userStore } from '../../store/user.js'
import {
    computed,
    onBeforeUnmount,
    onMounted,
    ref,
} from 'vue'

const props = defineProps({
    darkMode: Boolean,
    menuData: Array,
})

const navBar = ref(null)
const navBarSticky = ref(false)
const menubar = ref(null)

const filteredMenuData = computed(() => props.menuData.filter(menu => !menu.isOnlyInFooter))
const logo = computed(() => props.darkMode ? LogoWhite : LogoBlack)

const intersectionObserver = new IntersectionObserver(
    ([ entry ]) => navBarSticky.value = entry.intersectionRatio < 1,
    { threshold: [1] },
)

onMounted(() => {
    // Fix bug that causes automatic scrolling when clicking on NavBar links
    menubar.value.onItemClick = () => {}

    intersectionObserver.observe(navBar.value)
})
onBeforeUnmount(() => {
    intersectionObserver.disconnect()
})
</script>
