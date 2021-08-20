require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
import store from "./store";
import Utils from "./mixins/Utils";
import routes from './routes';
import toastr from 'toastr';
import Swal from 'sweetalert2';
import AOS from 'aos';
import{moment} from "./Filter/filter";
import DashboardLayout from "./layouts/DashboardLayout";
import AuthLayout from "./layouts/AuthLayout";
import ErrorLayout from "./layouts/ErrorLayout";
import VueProgressBar from 'vue-progressbar';

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(VueProgressBar, {
  color: 'rgb(57 193 123)',
  failedColor: 'red',
  height: '4px'
});
window.toastr = toastr;

Vue.prototype.__t = str => _.get(window.i18n, str, str.split('.').slice(-1).pop())
window.__t        = str => _.get(window.i18n, str, str.split('.').slice(-1).pop())

const router = new VueRouter({
    routes,
    mode: 'history'
})

window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Toast = Toast;


Vue.use(VueRouter);
Vue.mixin(Utils);

Vue.component('AuthLayout', AuthLayout);
Vue.component('DashboardLayout', DashboardLayout);
Vue.component('ErrorLayout', ErrorLayout);
/*Vue.component('invoiceLayout', invoiceLayout)*/

/* for Auth check*/
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.logedIn) {
            next({
                path: '/'
            })
        } else {
            next()
        }
    } else {
        next() // make sure to always call next()!
    }
});

const app = new Vue({
    el: '#content',
    store,
    router
});


