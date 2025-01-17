<template>
    <div class="cv-width flex gap-24 items-center mx-auto p-12">
        <img :src="getImageUrl(section.image.src)"
             :alt="getTranslation(translations, section.image.alt)"
             class="border-8 border-white dark:border-black rounded-full size-64"
        >
        <div class="flex flex-col justify-center w-full">
            <h1 class="dark:text-black font-semibold leading-none text-[82px] text-white uppercase">
                {{ getTranslation(translations, section.title) }}
            </h1>
            <div class="border border-white dark:border-black my-8"></div>
            <div class="gap-4 grid grid-cols-2">
                <div v-for="item in section.data"
                     :key="item.title"
                >
                    <a :href="getTranslation(translations, item.link)"
                       class="dark:text-black gap-4 group inline-flex items-center text-lg text-white"
                       target="_blank"
                    >
                        <i :class="item.icon"
                           class="fa-fw fa-lg"
                        ></i>
                        <span class="group-hover:underline underline-offset-8">
                            {{ getTranslation(translations, item.title) }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    section: Object,
    translations: Object,
})

const getImageUrl = (filename) => {
    return new URL(`/resources/images/pictures/${filename}`, import.meta.url).href
}
</script>
