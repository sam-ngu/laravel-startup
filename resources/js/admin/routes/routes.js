import VueRouter from 'vue-router'

import BaseDashboard from '../pages/BaseDashboard'

import {user} from './auth/user'
import {role} from './auth/role'


let routes = [
    {
        path: '/',
        component: BaseDashboard,
        name: 'home',
        meta: {
            breadcrumb: [
                {
                    text: 'Dashboard',
                    disabled: true,
                    href: '/admin/#/',
                }
            ],
        },
    },
].concat(user, role);  // add more route groups here


const router = new VueRouter({
    routes: routes,
});

router.beforeEach(function(to, from, next){

    next();
});



export default router
