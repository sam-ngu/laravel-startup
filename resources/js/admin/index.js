
import Vue from 'vue'
import '../install-composition-api';
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'
import './../bootstrap'
import BaseAdmin from './BaseAdmin.vue'
import routes from './routes/routes'
import vuetifyopt from "../vuetifyopt";
import store from "./vuex-store/store";
window.Vue = Vue;

Vue.config.productionTip = false;
Vue.use(VueRouter);
Vue.use(Vuetify);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('base-admin', BaseAdmin);

const index = new Vue({
    vuetify: new Vuetify(vuetifyopt),
    el: '#app',
    router: routes,
    store  // uncomment this if using vuex
});
