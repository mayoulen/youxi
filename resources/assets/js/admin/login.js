require('../bootstrap');
window.Vue = require('vue');
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)

Vue.component('moni-admin-login', require('./components/login.vue'));

const moniAdminLogin = new Vue({
    el: '#moniAdminLogin'
});



