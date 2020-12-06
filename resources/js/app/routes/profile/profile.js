import BaseProfile from '../../components/dashboard/profile/BaseProfile'
import ProfileUpdatePhone from '../../components/dashboard/profile/contact-info/ProfileUpdatePhone'
import ProfileUpdateName from '../../components/dashboard/profile/basic-info/ProfileUpdateName'
import ProfileUpdatePassword from '../../components/dashboard/profile/basic-info/ProfileUpdatePassword'

let baseBreadcrumb = [
    {
        text: 'My Profile',
        disabled: true,
        href: '/dashboard/#/profile',
    },
];

const profile = [
    {
        path: '/profile',
        component: BaseProfile,
        name: 'user-profile',
        meta: {
            breadcrumb: baseBreadcrumb,
        },
        children: [

        ]

    },
    {
        path: '/profile/phone',
        name: 'user-profile-phone',
        component: ProfileUpdatePhone,
        props: true,
        meta: {
            breadcrumb: baseBreadcrumb.concat({
                text: "Phone",
                disabled: true,
                href: '',
            })
        }
    },
    {
        path: '/profile/name',
        name: 'user-profile-name',
        component: ProfileUpdateName,
        props: true,
        meta: {
            breadcrumb: baseBreadcrumb.concat({
                text: "Name",
                disabled: true,
                href: '',
            })
        }
    },
    {
        path: '/profile/password',
        name: 'user-profile-password',
        component: ProfileUpdatePassword,
        props: true,
        meta: {
            breadcrumb: baseBreadcrumb.concat({
                text: "Password",
                disabled: true,
                href: '',
            })
        }
    },

];

export {profile}

