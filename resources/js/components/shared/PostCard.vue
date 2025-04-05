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
            <TagsList :tags="post.tags"
                      class="mb-4 mt-1"
            />
        </template>
        <template #content>
            <div v-html="DOMPurify.sanitize(getTranslation(post.translations, post.body))"
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
import DOMPurify from 'dompurify'
import TagsList from './TagsList.vue'

defineProps({
    post: Object,
})
</script>
