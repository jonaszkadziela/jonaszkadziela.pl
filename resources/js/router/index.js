import { createWebHistory, createRouter } from 'vue-router'
import routes from './routes'

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'font-bold',
    routes,
})

const initialTitle = document.title

router.beforeEach(to => {
    const key = `main.titles.${to.name}`

    if (!Lang.has(key)) {
        document.title = initialTitle
        return
    }

    document.title = `${Lang.get(key)} - ${initialTitle}`
})

export default router
