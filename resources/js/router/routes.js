const CvPage = () => import('../components/pages/CvPage.vue')
const HomePage = () => import('../components/pages/HomePage.vue')
const NotFoundPage = () => import('../components/pages/NotFoundPage.vue')

export default [
    { path: '/', name: 'home', component: HomePage },
    { path: '/cv', name: 'cv', component: CvPage },
    { path: '/:pathMatch(.*)*', name: 'error-404', component: NotFoundPage },
]
