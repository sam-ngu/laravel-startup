import BaseUserManagement from '../../../backend/components/user-management/BaseUserManagement'
import BaseUserUpdate from '../../components/user-management/user-update/BaseUserUpdate'
import BaseUserCreate from '../../../backend/components/user-management/user-create/BaseUserCreate'


let baseBreadcrumb = [
    {
        text: 'User Management',
        disabled: true,
        href: '/admin/#/auth/user',
    },
];


const user = [
    {
        path: '/auth/user',
        component: BaseUserManagement,
        name: 'user-management',
        meta: {
            breadcrumb: baseBreadcrumb,
        },
        children: [
            {
                path: '/auth/user/:id',
                name: 'user-show',
                component: BaseUserUpdate,
                props: true,
                meta: {
                    breadcrumb: baseBreadcrumb.concat({
                        text: "User Details",
                        disabled: true,
                        href: '',
                    })
                }
            },
            {
                path: '/auth/user/create',
                name: 'user-create',
                component: BaseUserCreate,
                props: true,
                meta: {
                    breadcrumb: baseBreadcrumb.concat({
                        text: "Create User",
                        disabled: true,
                        href: '',
                    })
                }

            }
        ]

    },

];

export {user}
