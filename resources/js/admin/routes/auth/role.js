import BaseRoleManagement from '../../../admin/components/role-management/BaseRoleManagement'
import BaseRoleUpdate from '../../../admin/components/role-management/role-update/BaseRoleUpdate'
import BaseRoleCreate from '../../../admin/components/role-management/role-create/BaseRoleCreate'

let baseBreadcrumb = [
    {
        text: 'Role Management',
        disabled: true,
        href: '/admin/#/auth/role',
    },
];

const role = [
    {
        path: '/auth/role',
        component: BaseRoleManagement,
        name: 'role-management',
        meta: {
            breadcrumb: baseBreadcrumb,
        },
        children: [
            {
                path: '/auth/role/:id',
                name: 'role-show',
                component: BaseRoleUpdate,
                props: true,
                meta: {
                    breadcrumb: baseBreadcrumb.concat({
                        text: "Role Details",
                        disabled: true,
                        href: '',
                    })
                }

            },
            {
                path: '/auth/role/create',
                name: 'role-create',
                component: BaseRoleCreate,
                props: true,
                meta: {
                    breadcrumb: baseBreadcrumb.concat({
                        text: "Create Role",
                        disabled: true,
                        href: '',
                    })
                }

            }
        ]

    },
];

export {role}
