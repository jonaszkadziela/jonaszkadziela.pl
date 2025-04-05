import { createWebHistory, createRouter } from 'vue-router'
import routes from './routes'

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'font-bold',
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return new Promise(resolve => {
                setTimeout(() => resolve({
                    el: to.hash,
                    top: to.name === 'cv' ? 80 : 65,
                    behavior: 'smooth',
                }), 500)
            })
        }

        if (savedPosition) {
            return savedPosition
        }

        return {
            left: 0,
            top: 0,
        }
    },
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

router.beforeEach(() => {
    const navBarButton = document.querySelector('nav [aria-expanded="true"]')

    if (navBarButton) {
        navBarButton.click()
    }
})

export default router
