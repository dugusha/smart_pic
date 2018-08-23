import Vue from 'vue'
import Element from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './../entry/web.vue'
import Router from 'vue-router'

import SmartPic from '@/components/web/SmartPic'
import Drop from '@/components/web/Drop'

Vue.use(Element)
Vue.use(Router)

const router = new Router({
    routes: [
        {
            path: '/',
            name: 'SmartPic',
            component: SmartPic
        },
        {
            path: '/drop',
            name: 'drop',
            component: Drop
        }
    ]
})

new Vue({
    data: {},
    el: '#app',
    router,
    render: h => h(App)
})
