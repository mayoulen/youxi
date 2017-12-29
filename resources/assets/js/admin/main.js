require('../bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)
// scrolly
import { Scrolly, ScrollyViewport, ScrollyBar } from 'vue-scrolly';
Vue.component('vue-scrolly', Scrolly)
Vue.component('vue-scrolly-viewport', ScrollyViewport)
Vue.component('vue-scrolly-bar', ScrollyBar)

// 城市筛选 region
import region from './components/region.vue'
Vue.component('vue-region', region);

// 用户管理
import userList from './components/user/lists.vue'
Vue.component('vue-user-lists', userList);
import userCreate from './components/user/create.vue'
Vue.component('vue-user-create', userCreate);
import userEdit from './components/user/edit.vue'
Vue.component('vue-user-edit', userEdit);

import vueRouter from 'vue-router';
Vue.use(vueRouter);
const router = new vueRouter({
  routes:[
  	// 用户管理
    {name: 'user-lists',path: '/user-lists',component: userList, props: true},
    {name: 'user-create',path: '/user-create',component: userCreate, props: true},
    {name: 'user-edit',path: '/user-edit/:user_id',component: userEdit, props: true},

  ]
});

const moniAdmin = new Vue({
    el: '#moniAdmin',
    router
});



