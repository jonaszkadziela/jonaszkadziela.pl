<template>
    <Card :pt="{
        body: 'p-6',
        root: 'dark:shadow-blue-800/80 duration-300 hover:shadow-xl transition-shadow',
    }"
    >
        <template #header>
            <div :style="`background-image: url(${post.image});`"
                 class="bg-center bg-cover min-h-64 rounded-t-xl"
            ></div>
        </template>
        <template #title>
            <h4 class="font-semibold text-3xl">
                {{ getTranslation(post.translations, post.title) }}
            </h4>
        </template>
        <template #subtitle>
            <div class="flex flex-wrap gap-2 mb-4 mt-1">
                <Tag v-for="(tag, index) in post.tags"
                     :key="tag.name"
                     :severity="index === 0 ? 'primary' : 'secondary'"
                     :value="getTranslation(tag.translations, tag.name)"
                     rounded
                />
            </div>
        </template>
        <template #content>
            <div v-html="getTranslation(post.translations, post.body)"
                 class="formatted-html"
            ></div>
        </template>
        <template #footer>
            <div class="mt-4">
                <Button :label="Lang.get('home.buttons.read-more')"
                        :to="`/blog/${post.slug}`"
                        as="RouterLink"
                        severity="primary"
                        rounded
                />
            </div>
        </template>
    </Card>
</template>

<script setup>
defineProps({
    post: Object,
})
</script>
