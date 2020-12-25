import VueRouter from 'vue-router'

import BaseHome from '../containers/home/BaseHome'

// import {user} from '../routes/auth/user'
import {profile} from "./profile/profile";

let routes = [
    {
        path: '/',
        component: BaseHome,
        name: 'home',
        meta: {
            breadcrumb: [
                {
                    text: 'App',
                    disabled: true,
                    href: '/app',
                },
            ],
        },
    },

].concat( profile);  // add more route groups here


const router = new VueRouter({
    routes: routes,
});

router.beforeEach(function(to, from, next){

    // if(to.matched.some(record => {
    //     console.log(record)
    // }))

    //

    next()
});

export default router
