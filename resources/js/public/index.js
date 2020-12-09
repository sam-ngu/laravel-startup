require('../bootstrap');

import Vue from 'vue';
import Vuetify from 'vuetify'
import upperFirst from 'lodash/upperFirst';
import camelCase from 'lodash/camelCase';
import vuetifyopt from "../vuetifyopt";
import store from "../app/vuex-store/store";
window.Vue = Vue;


// Require in a base component context
const requireComponent = require.context('.', false, /.vue$/)



// autoloading all public folder components
requireComponent.keys().forEach(fileName => {

    // get component config
    const componentConfig = requireComponent(fileName);

    // get PascalCase component name
    const componentName = upperFirst(
        camelCase(fileName.replace(/^\.\//, '').replace(/\.\w+$/, ''))
    )


    // Register component globally
    // componentConfig.default || componentConfig  --> this check if component is exported default or using the specified export
    Vue.component(componentName, componentConfig.default || componentConfig);
})

Vue.config.productionTip = false;
Vue.use(Vuetify);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


const index = new Vue({
    vuetify: new Vuetify(vuetifyopt),
    el: '#app',
    // router: routes,
    store  // uncomment this if using vuex
});
