<template>
    <Card :pt="{
        body: 'md:w-3/4 p-6',
        footer: 'mt-auto',
        header: 'flex md:w-1/4',
        root: 'dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl md:flex-row transition-shadow',
    }">
        <template #header>
            <Image :pt="{
                       root: 'min-h-72 overflow-hidden relative w-full',
                       image: 'absolute inset-0 lg:my-0 md:my-auto',
                       previewMask: 'md:rounded-l-xl md:rounded-tr-none rounded-t-xl',
                   }"
                   :src="project.image"
                   :alt="`Project - ${getTranslation(project.translations, project.title)}`"
                   preview
            />
        </template>
        <template #title>
            <div class="flex flex-col gap-2 justify-between lg:flex-row">
                <h4 class="font-semibold text-3xl">
                    {{ getTranslation(project.translations, project.title) }}
                </h4>
                <div class="flex flex-col gap-1 lg:flex-row lg:gap-4 lg:text-xl text-sm">
                    <p v-if="project.isProBono"
                       class="flex gap-2 items-center"
                    >
                        <i class="fa-solid fa-hand-holding-dollar fa-fw"></i>
                        {{ Lang.get('main.pro-bono') }}
                    </p>
                    <p class="capitalize flex gap-2 items-center">
                        <i class="fa-solid fa-calendar-days fa-fw"></i>
                        {{ project.startedAt }} - {{ project.finishedAt || Lang.get('main.present') }}
                    </p>
                </div>
            </div>
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
                 class="formatted-html"
            ></div>
        </template>
        <template #footer>
            <div class="flex flex-col gap-2 md:flex-row mt-4">
                <Button v-if="project.link"
                        :href="project.link"
                        :label="Lang.get('main.buttons.project-page')"
                        as="a"
                        icon="fa-solid fa-up-right-from-square"
                        iconPos="right"
                        severity="secondary"
                        target="_blank"
                        rounded
                />
                <Button :label="Lang.get('main.buttons.see-details')"
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
