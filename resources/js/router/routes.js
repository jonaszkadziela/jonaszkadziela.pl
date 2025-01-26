const ContactPage = () => import('../components/pages/ContactPage.vue')
const CvPage = () => import('../components/pages/CvPage.vue')
const HomePage = () => import('../components/pages/HomePage.vue')
const PortfolioPage = () => import('../components/pages/PortfolioPage.vue')
const NotFoundPage = () => import('../components/pages/NotFoundPage.vue')

export default [
    { path: '/', name: 'home', component: HomePage },
    { path: '/contact', name: 'contact', component: ContactPage },
    { path: '/cv', name: 'cv', component: CvPage },
    { path: '/portfolio', name: 'portfolio', component: PortfolioPage },
    { path: '/:pathMatch(.*)*', name: 'error-404', component: NotFoundPage },
]
