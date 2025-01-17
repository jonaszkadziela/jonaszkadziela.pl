<template>
    <div>
        <section id="introduction"
                 class="container flex flex-col gap-12 items-center justify-center md:flex-row md:gap-24 md:min-h-[85vh] md:text-left mx-auto px-4 py-16 relative text-center"
        >
            <div class="flex flex-col max-w-2xl md:order-first order-last">
                <h1 class="text-6xl font-bold mb-1">
                    {{ Lang.get('home.introduction.title') }}
                </h1>
                <h2 class="mb-12 text-3xl">
                    {{ Lang.get('home.introduction.subtitle') }}
                </h2>
                <p class="dark:text-gray-300 mb-12 text-gray-600 text-lg">
                    {{ Lang.get('home.introduction.description') }}.
                </p>
                <div class="flex flex-col gap-4 justify-center md:flex-row md:justify-start">
                    <Button :label="Lang.get('home.buttons.get-in-touch')"
                            as="RouterLink"
                            severity="secondary"
                            to="/contact"
                            rounded
                    />
                    <Button :label="Lang.get('home.buttons.view-portfolio')"
                            as="RouterLink"
                            class="bg-gradient-to-r dark:shadow-blue-800/80 dark:text-white duration-300 from-blue-600 hover:-translate-y-0.5 hover:shadow-xl to-blue-900 transition-all"
                            to="/portfolio"
                            rounded
                    />
                </div>
            </div>
            <img :src="FullBodyPicture"
                 alt="Picture"
                 class="h-64 md:h-auto"
            >
            <Button :label="Lang.get('home.buttons.see-more')"
                    as="a"
                    class="-mb-6 absolute bg-blue-50 border-blue-50 bottom-0 dark:bg-blue-950 dark:border-blue-950 dark:hover:bg-blue-900 dark:text-blue-100 hover:bg-blue-100 text-blue-900"
                    href="#featured-posts"
                    icon="fa fa-chevron-down"
                    iconPos="right"
                    severity="secondary"
                    rounded
            />
        </section>
        <section id="featured-posts"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
        >
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mb-16 mx-auto text-center">
                    <h3 class="text-4xl font-bold mb-4">
                        {{ Lang.get('home.featured-posts.title') }}
                    </h3>
                    <p class="dark:text-blue-200 text-blue-800">
                        {{ Lang.get('home.featured-posts.description') }}.
                    </p>
                </div>
                <div class="flex flex-wrap gap-8 justify-center">
                    <Card v-for="post in blogData"
                          :key="post.id"
                          :pt="{
                              body: 'p-6',
                              root: 'dark:shadow-blue-800/80 duration-300 hover:shadow-xl md:w-[calc(50%-16px)] transition-shadow w-full',
                          }"
                    >
                        <template #header>
                            <div :style="`background-image: url(${post.image});`"
                                 class="bg-center bg-cover min-h-64 rounded-t-xl"
                            ></div>
                        </template>
                        <template #title>
                            <h4 class="font-semibold text-3xl">
                                {{ post.title }}
                            </h4>
                        </template>
                        <template #subtitle>
                            <div class="flex flex-wrap gap-2 mb-4 mt-1">
                                <Tag v-for="tag in post.tags"
                                     :key="tag.value"
                                     :severity="tag.order === 0 ? 'primary' : 'secondary'"
                                     :value="tag.value"
                                     rounded
                                />
                            </div>
                        </template>
                        <template #content>
                            <div v-html="post.body"></div>
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
                </div>
                <div class="mt-8 text-center">
                    <RouterLink class="hover:underline underline-offset-8"
                                to="/blog"
                    >
                        {{ Lang.get('home.featured-posts.view-all') }}
                    </RouterLink>
                </div>
            </div>
        </section>
        <section id="my-expertise"
                 class="container mx-auto px-4 py-16"
        >
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold mb-4">
                    {{ Lang.get('home.my-expertise.title') }}
                </h3>
                <p class="dark:text-gray-300 mb-12 text-gray-600">
                    {{ Lang.get('home.my-expertise.description') }}.
                </p>
            </div>
            <div class="gap-8 grid grid-cols-1 md:grid-cols-2">
                <RouterLink v-for="expertise in expertiseData"
                            :key="expertise.id"
                            :to="expertise.link"
                            class="border dark:shadow-blue-800/80 flex flex-row gap-6 group hover:shadow-xl p-6 relative rounded-xl transition-shadow"
                >
                    <i :class="expertise.icon"
                       class="duration-300 group-hover:text-blue-700 text-4xl"
                    ></i>
                    <div class="flex flex-col gap-4">
                        <h4 class="duration-300 font-semibold group-hover:text-blue-700 text-2xl">
                            {{ expertise.title }}
                        </h4>
                        <p class="dark:text-gray-300 text-gray-600">
                            {{ expertise.body }}
                        </p>
                    </div>
                    <div class="-translate-x-4 absolute duration-300 group-hover:opacity-100 group-hover:translate-x-0 opacity-0 right-5 text-2xl text-blue-700 top-5 transition-transform">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                </RouterLink>
            </div>
        </section>
        <section id="selected-projects"
                 class="bg-blue-50 dark:bg-blue-950 dark:text-blue-100 py-16 text-blue-900"
        >
            <div class="container mx-auto px-4">
                <div class="max-w-2xl mb-16 mx-auto text-center">
                    <h3 class="text-4xl font-bold mb-4">
                        {{ Lang.get('home.selected-projects.title') }}
                    </h3>
                    <p class="dark:text-blue-200 text-blue-800">
                        {{ Lang.get('home.selected-projects.description') }}.
                    </p>
                </div>
                <div class="gap-8 grid grid-cols-1">
                    <Card v-for="project in projectData"
                          :key="project.id"
                          :pt="{
                              body: 'p-6',
                              footer: 'mt-auto',
                              root: 'dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl md:flex-row transition-shadow',
                          }"
                    >
                        <template #header>
                            <div :style="`background-image: url(${project.image});`"
                                 class="bg-center bg-cover h-full md:min-w-96 md:rounded-l-xl md:rounded-tr-none min-h-80 rounded-t-xl"
                            ></div>
                        </template>
                        <template #title>
                            <h4 class="font-semibold text-3xl">
                                {{ project.title }}
                            </h4>
                        </template>
                        <template #subtitle>
                            <div class="flex flex-wrap gap-2 mb-4 mt-1">
                                <Tag v-for="tag in project.tags"
                                     :key="tag.value"
                                     :severity="tag.order === 0 ? 'primary' : 'secondary'"
                                     :value="tag.value"
                                     rounded
                                />
                            </div>
                        </template>
                        <template #content>
                            <div v-html="project.body"></div>
                        </template>
                        <template #footer>
                            <div class="mt-4">
                                <Button :label="Lang.get('home.buttons.see-details')"
                                        :to="project.link"
                                        as="RouterLink"
                                        severity="primary"
                                        rounded
                                />
                            </div>
                        </template>
                    </Card>
                </div>
                <div class="mt-8 text-center">
                    <RouterLink class="hover:underline underline-offset-8"
                                to="/portfolio"
                    >
                        {{ Lang.get('home.selected-projects.view-all') }}
                    </RouterLink>
                </div>
            </div>
        </section>
        <section id="my-achievements"
                 class="container mx-auto px-4 py-16"
        >
            <div class="max-w-2xl mb-16 mx-auto text-center">
                <h3 class="text-4xl font-bold mb-4">
                    {{ Lang.get('home.my-achievements.title') }}
                </h3>
                <p class="dark:text-gray-300 mb-12 text-gray-600">
                    {{ Lang.get('home.my-achievements.description') }}.
                </p>
            </div>
            <div class="gap-8 grid grid-cols-1 lg:grid-cols-4 md:grid-cols-2">
                <Card v-for="achievement in achievementData"
                      :key="achievement.id"
                      :pt="{
                          body: 'p-6',
                          root: 'border dark:shadow-blue-800/80 duration-300 flex flex-col hover:shadow-xl shadow-none transition-shadow',
                      }"
                >
                    <template #header>
                        <Image :src="achievement.image"
                               :pt="{
                                   root: 'min-h-64 w-full',
                                   image: 'object-cover rounded-t-xl w-full',
                                   previewMask: 'rounded-t-xl',
                               }"
                               :alt="`Achievement - ${achievement.title}`"
                               preview
                        />
                    </template>
                    <template #title>
                        <RouterLink :to="achievement.link">
                            <h4 class="font-semibold text-3xl">
                                {{ achievement.title }}
                            </h4>
                        </RouterLink>
                    </template>
                </Card>
            </div>
            <div class="mt-8 text-center">
                <RouterLink class="hover:underline underline-offset-8"
                            to="/cv#achievements"
                >
                    {{ Lang.get('home.my-achievements.view-all') }}
                </RouterLink>
            </div>
        </section>
    </div>
</template>

<script setup>
import FullBodyPicture from '@/images/pictures/fullbody-picture.png'

const blogData = [
    {
        id: 1,
        title: 'Non Consequuntur Vero',
        body: '<p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae porro omnis perferendis sint illo quidem, quasi ullam accusamus harum ex voluptatibus debitis cupiditate sequi dolor nostrum fuga dolorem esse obcaecati.</p><p>Ad ullam, iusto mollitia perferendis ipsa pariatur eaque tempora atque exercitationem molestiae officiis quos facilis. Culpa excepturi accusamus quidem accusantium! Rem, quod?</p>',
        slug: 'non-consequuntur-vero-1',
        image: 'https://picsum.photos/600/400',
        tags: [
            {
                order: 0,
                value: 'Latest',
            },
            {
                order: 1,
                value: 'Web Application',
            },
            {
                order: 2,
                value: 'Laravel',
            },
        ],
    },
    {
        id: 2,
        title: 'Molestiae Porro Omnis',
        body: '<p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestiae porro omnis perferendis sint illo quidem, quasi ullam accusamus harum ex voluptatibus debitis cupiditate sequi dolor nostrum fuga dolorem esse obcaecati.</p><p>Ad ullam, iusto mollitia perferendis ipsa pariatur eaque tempora atque exercitationem molestiae officiis quos facilis. Culpa excepturi accusamus quidem accusantium! Rem, quod?</p>',
        slug: 'molestiae-porro-omnis-2',
        image: 'https://picsum.photos/600/401',
        tags: [
            {
                order: 0,
                value: 'Security',
            },
            {
                order: 1,
                value: 'Password Policy',
            },
        ],
    },
]

const expertiseData = [
    {
        id: 1,
        title: 'Programming',
        body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error nemo autem vero sed mollitia, dolorum quaerat nam sequi veritatis, laudantium nesciunt aliquid saepe totam facilis quos deserunt quod quas aspernatur.',
        link: '/cv#programming',
        icon: 'fa fa-code',
    },
    {
        id: 2,
        title: 'Graphics Design',
        body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error nemo autem vero sed mollitia, dolorum quaerat nam sequi veritatis, laudantium nesciunt aliquid saepe totam facilis quos deserunt quod quas aspernatur.',
        link: '/cv#graphics-design',
        icon: 'fa fa-paintbrush',
    },
    {
        id: 3,
        title: 'System Administration',
        body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error nemo autem vero sed mollitia, dolorum quaerat nam sequi veritatis, laudantium nesciunt aliquid saepe totam facilis quos deserunt quod quas aspernatur.',
        link: '/cv#system-administration',
        icon: 'fa fa-server',
    },
    {
        id: 4,
        title: 'And More! :)',
        body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Error nemo autem vero sed mollitia, dolorum quaerat nam sequi veritatis, laudantium nesciunt aliquid saepe totam facilis quos deserunt quod quas aspernatur.',
        link: '/cv#more',
        icon: 'fa fa-wand-magic-sparkles',
    },
]

const projectData = [
    {
        id: 1,
        title: 'EverestServer',
        body: '<p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid totam numquam, saepe tenetur dolor inventore animi esse. Vero, minima possimus qui libero enim neque dignissimos dolore quibusdam? Voluptate, necessitatibus enim.</p><p>Phasellus euismod dictum elit, eu convallis elit vestibulum nec. Donec volutpat dui id iaculis viverra. Maecenas id iaculis massa, sed vestibulum justo.</p>',
        link: '/portfolio/everestserver',
        image: 'https://picsum.photos/600/402',
        tags: [
            {
                order: 0,
                value: 'Laravel',
            },
            {
                order: 1,
                value: 'PHP',
            },
            {
                order: 2,
                value: 'Tailwind CSS',
            },
            {
                order: 3,
                value: 'Alpine.js',
            },
        ],
    },
    {
        id: 2,
        title: 'Kadziela Hub',
        body: '<p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid totam numquam, saepe tenetur dolor inventore animi esse. Vero, minima possimus qui libero enim neque dignissimos dolore quibusdam? Voluptate, necessitatibus enim.</p><p>Phasellus euismod dictum elit, eu convallis elit vestibulum nec. Donec volutpat dui id iaculis viverra. Maecenas id iaculis massa, sed vestibulum justo.</p>',
        link: '/portfolio/kadziela-hub',
        image: 'https://picsum.photos/600/403',
        tags: [
            {
                order: 0,
                value: 'Laravel',
            },
            {
                order: 1,
                value: 'PHP',
            },
            {
                order: 2,
                value: 'Tailwind CSS',
            },
            {
                order: 3,
                value: 'Alpine.js',
            },
        ],
    },
    {
        id: 3,
        title: 'BetterGram',
        body: '<p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid totam numquam, saepe tenetur dolor inventore animi esse. Vero, minima possimus qui libero enim neque dignissimos dolore quibusdam? Voluptate, necessitatibus enim.</p><p>Phasellus euismod dictum elit, eu convallis elit vestibulum nec. Donec volutpat dui id iaculis viverra. Maecenas id iaculis massa, sed vestibulum justo.</p>',
        link: '/portfolio/bettergram',
        image: 'https://picsum.photos/600/404',
        tags: [
            {
                order: 0,
                value: 'PHP',
            },
            {
                order: 1,
                value: 'jQuery',
            },
        ],
    },
]

const achievementData = [
    {
        id: 1,
        title: '1st place in the Cisco NetRiders ITE competition',
        link: '/cv#achievements',
        image: 'https://picsum.photos/600/405',
    },
    {
        id: 2,
        title: '1st place in the Robocode League',
        link: '/cv#achievements',
        image: 'https://picsum.photos/600/406',
    },
        {
        id: 3,
        title: 'Winner in one of the categories at the Robo Inspector Hackathon',
        link: '/cv#achievements',
        image: 'https://picsum.photos/600/407',
    },
    {
        id: 4,
        title: 'Scholarship for very good academic results',
        link: '/cv#achievements',
        image: 'https://picsum.photos/600/408',
    },
]
</script>

<style>
html {
    scroll-padding-top: 65px;
}
</style>
