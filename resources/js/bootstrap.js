import axios from 'axios'

const absoluteUrlRegex = new RegExp('^(?:[a-z+]+:)?//', 'i')

window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.interceptors.request.use(config => {
    if (!absoluteUrlRegex.test(config.url)) {
        config.url = `/api${config.url}`
        config.headers['X-Language'] = Lang.getLocale()
    }

    return config
})
