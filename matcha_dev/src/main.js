import Vue from 'vue'
import Main from './components/Main.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/default.css'
import Confirmed from './components/Confirmed.vue'
import CxltToastr from 'cxlt-vue2-toastr'
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css'
import * as VueGoogleMaps from 'vue2-google-maps'

var toastrConfigs = {
    position: 'top right',
    showDuration: 3000
}
global.jQuery = require('jquery');
Vue.use(VueMaterial);
Vue.use(VueAxios, axios);
Vue.use(VueRouter);
Vue.use(CxltToastr, toastrConfigs);
Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyAcMXSw8AhlD839KUA2bBfQXmRfuTeDrQ4',
        libraries: 'places'
    },
})
const $ = global.jQuery;
window.$ = $;
const routes = [
    {path: '/confirmation/:hash', component: Confirmed}
]

const router = new VueRouter({
    mode: 'history',
    routes: routes
})

Vue.config.productionTip = false;

new Vue({
    router,
    render: h => h(Main),
}).$mount('#app');

