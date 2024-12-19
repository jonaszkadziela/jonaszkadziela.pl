const CvPage = () => import('../components/pages/CvPage.vue')
const HomePage = () => import('../components/pages/HomePage.vue')

export default [
    { path: '/', name: 'home', component: HomePage },
    { path: '/cv', name: 'cv', component: CvPage },
]
