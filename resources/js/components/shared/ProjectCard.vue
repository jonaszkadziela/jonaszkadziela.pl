<template>
    <Card :pt="{
        body: 'p-6',
        footer: 'mt-auto',
        root: 'dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl md:flex-row transition-shadow',
    }">
        <template #header>
            <div :style="`background-image: url(${project.image});`"
                 class="bg-center bg-cover h-full md:min-w-96 md:rounded-l-xl md:rounded-tr-none min-h-80 rounded-t-xl"
            ></div>
        </template>
        <template #title>
            <h4 class="font-semibold text-3xl">
                {{ getTranslation(project.translations, project.title) }}
            </h4>
        </template>
        <template #subtitle>
            <div class="flex flex-wrap gap-2 mb-4 mt-1">
                <Tag v-for="(tag, index) in project.tags"
                     :key="tag.name"
                     :severity="index === 0 ? 'primary' : 'secondary'"
                     :value="getTranslation(tag.translations, tag.name)"
                     rounded
                />
            </div>
        </template>
        <template #content>
            <div v-html="getTranslation(project.translations, project.body)"
                 class="project-body"
            ></div>
        </template>
        <template #footer>
            <div class="mt-4">
                <Button :label="Lang.get('home.buttons.see-details')"
                        :to="project.route"
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
    project: Object,
})
</script>

<style>
.project-body ul {
    margin-left: 1.25rem;
}

.project-body li {
    list-style-type: disc;
}

@media (max-width: 768px) {
    .project-body li {
        list-style-position: inside;
    }
}
</style>
