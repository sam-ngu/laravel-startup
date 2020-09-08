import BaseUserManagement from '../../pages/BaseUserManagement'
import BaseUserUpdate from '../../components/user-management/user-update/BaseUserUpdate'
import BaseUserCreate from '../../components/user-management/user-create/BaseUserCreate'
import BaseUser from "../../containers/auth/BaseUser";

let baseBreadcrumb = [
    {
        text: 'User Management',
        disabled: true,
        href: '/admin/#/auth/user/manage',
    },
];

const resourceName = 'user';

const user = [
    {
        path: '/auth/user',
        component: BaseUser,
        name: 'user-management',
        meta: {
            breadcrumb: baseBreadcrumb,
            resourceName,
        },
    },
    {
        path: '/auth/user/*',
        redirect: 'user-management',
    },

];

export {user}
