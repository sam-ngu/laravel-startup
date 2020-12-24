import BaseProfile from '../../containers/profile/BaseProfile'
import ProfileUpdatePhone from '../../containers/profile/contact-info/ProfileUpdatePhone'
import ProfileUpdateName from '../../containers/profile/basic-info/ProfileUpdateName'
import ProfileUpdatePassword from '../../containers/profile/basic-info/ProfileUpdatePassword'
import ProfileUpdate2FA from "../../containers/profile/security/ProfileUpdate2FA";

let baseBreadcrumb = [
    {
        text: 'My Profile',
        disabled: true,
        href: '/app/#/profile',
    },
];

export const profile = [
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
    {
        path: '/profile/2fa',
        name: 'user-profile-2fa',
        component: ProfileUpdate2FA,
        props: true,
        meta: {
            breadcrumb: baseBreadcrumb.concat({
                text: "2 Factor Authentication",
                disabled: true,
                href: '',
            })
        }
    },

];


