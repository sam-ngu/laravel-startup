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

    console.log({to});
    console.log({from});
    //
    // const toSplitted = to.name.split('-');
    // console.log(toSplitted[toSplitted.length -1]);
    // if(toSplitted[toSplitted.length - 1] === 'management'){
    //     console.log('pushing');
    //
    //     const path = to.path + '/manage';
    //
    //     console.log({path});
    //     next(path);
    //
    // }else {
    //     next()
    // }

    next();
});

router.afterEach((to, from) => {


    // const toSplitted = to.name.split('-');
    // console.log(toSplitted[toSplitted.length -1]);
    //
    // if(toSplitted[toSplitted.length - 1] === 'management'){
    //
    //     console.log('pushing');
    //
    //     const path = to.path + '/manage';
    //
    //     // router.push(path);
    //
    //
    // }

})

export default router
