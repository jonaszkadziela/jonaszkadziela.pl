const BlogPage = () => import('../components/pages/BlogPage.vue')
const BlogShowPage = () => import('../components/pages/BlogShowPage.vue')
const ContactPage = () => import('../components/pages/ContactPage.vue')
const CvPage = () => import('../components/pages/CvPage.vue')
const DocumentsPage = () => import('../components/pages/DocumentsPage.vue')
const DocumentShowPage = () => import('../components/pages/DocumentShowPage.vue')
const HomePage = () => import('../components/pages/HomePage.vue')
const NotFoundPage = () => import('../components/pages/NotFoundPage.vue')
const PortfolioPage = () => import('../components/pages/PortfolioPage.vue')
const PortfolioShowPage = () => import('../components/pages/PortfolioShowPage.vue')
const PrivacyPage = () => import('../components/pages/PrivacyPage.vue')

export default [
    { path: '/', name: 'home', component: HomePage },
    { path: '/blog', name: 'blog', component: BlogPage },
    { path: '/blog/:slug', name: 'blog-show', component: BlogShowPage },
    { path: '/contact', name: 'contact', component: ContactPage },
    { path: '/cv', name: 'cv', component: CvPage },
    { path: '/documents', name: 'documents', component: DocumentsPage },
    { path: '/documents/:slug', name: 'document-show', component: DocumentShowPage },
    { path: '/portfolio', name: 'portfolio', component: PortfolioPage },
    { path: '/portfolio/:slug', name: 'portfolio-show', component: PortfolioShowPage },
    { path: '/privacy', name: 'privacy', component: PrivacyPage },
    { path: '/:pathMatch(.*)*', name: 'error-404', component: NotFoundPage },
]
