import VueRouter from 'vue-router'

import BaseDashboard from '../../admin/components/dashboard/BaseDashboard'

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
    //     [
    //
    //
    //     // {
    //     //     path: '/backtest/:backtest_id',
    //     //     name: 'backtest-details',
    //     //     component: BacktestDetails,
    //     //     // props: true,
    //     // }
    //
    // ],
});

router.beforeEach(function(to, from, next){
    // if entering control area, check if user is admin and prompt for entering password

    // if(to.matched.some(record => {
    //     console.log(record)
    // }))

    //

    next()
});

export default router
