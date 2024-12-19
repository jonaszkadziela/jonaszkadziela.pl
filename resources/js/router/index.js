import { createWebHistory, createRouter } from 'vue-router'
import routes from './routes'

const router = createRouter({
    history: createWebHistory(),
    linkActiveClass: 'font-bold',
    routes,
})

export default router
