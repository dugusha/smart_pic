import Vue from 'vue'
import App from './../entry/mobile.vue'
import Router from 'vue-router'

import Mobile from '@/components/mobile/Mobile'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/',
      name: 'Mobile',
      component: Mobile
    }
  ]
})

new Vue({
    el: '#app',
    router,
    components: { App },
    template: '<App/>'
})
