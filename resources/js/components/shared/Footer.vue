<template>
    <footer class="bg-white border-t dark:bg-black dark:border-none">
        <div class="container dark:text-gray-300 mx-auto px-4 py-16 text-gray-600">
            <div class="gap-8 grid grid-cols-3 justify-items-center mb-12 md:grid-cols-6 mx-auto w-1/2">
                <a v-for="social in socialData"
                   :href="social.link"
                   :key="social.id"
                   class="duration-300 hover:text-blue-600 text-3xl text-blue-500 transition-color"
                   target="_blank"
                >
                    <i v-tooltip.top="social.title"
                       :class="social.icon"
                    ></i>
                </a>
                <template v-if="socialData === null">
                    <Skeleton v-for="index in [...Array(6).keys()]"
                              :key="index"
                              size="2.5rem"
                    />
                </template>
            </div>
            <div class="flex flex-col gap-4 items-center justify-center mb-12 md:flex-row md:gap-8">
                <RouterLink v-for="item in menuData"
                            :key="item.label"
                            :to="item.route"
                            class="hover:underline underline-offset-8"
                >
                    {{ item.label }}
                </RouterLink>
            </div>
            <div class="text-center">
                {{ Lang.get('main.footer.programmed-with') }}
                <i class="fa-solid fa-heart text-blue-500"></i>
                {{ Lang.get('main.footer.by') }}
                <a class="duration-300 hover:text-blue-600 hover:underline text-blue-500 transition-color underline-offset-8"
                   href="https://jonaszkadziela.pl"
                   target="_blank"
                >
                    {{ Lang.get('main.footer.author') }}
                </a>
            </div>
        </div>
    </footer>
</template>

<script setup>
defineProps({
    menuData: Array,
    socialData: Array,
})
</script>
