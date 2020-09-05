import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

// https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
const createRouter = (routes) => new Router({
    routes
})

export function resetRouter (router) {

    const newRouter = createRouter(router.options.routes);
    router.matcher = newRouter.matcher // the relevant part
}
