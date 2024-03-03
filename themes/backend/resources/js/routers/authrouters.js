import Permission from './../components/auth/permission/index.vue';
import PermissionForm from './../components/auth/permission/form.vue';

import Role from './../components/auth/role/index.vue';
import RoleForm from './../components/auth/role/form.vue';

import AdminList from './../components/auth/admin/index.vue';
import AdminForm from './../components/auth/admin/form.vue';


import DeviceList from './../components/device/index.vue';
import DeviceForm from './../components/device/form.vue';


import ProfileForm from './../components/auth/profile/form.vue';

import Dashboard from './../components/dashboard/index.vue';

import PostList from './../components/post/index.vue';
import PostForm from './../components/post/form.vue';

const currentLocale = '/' + window.MonCMS.currentLocale;

export default [
    {
        path: '/admin',
        name: 'admin.dashboard.index',
        component: Dashboard,
    },
    {
        path: '/admin/auth/permissions',
        name: 'admin.permissions.index',
        component: Permission,
    },
    {
        path: '/admin/auth/permissions/create',
        name: 'admin.permissions.create',
        component: PermissionForm,
        props: {
            pageTitle: 'permission.label.create_permission',
        },
    },

    {
        path: '/admin/auth/permissions/:permissionId/edit',
        name: 'admin.permissions.edit',
        component: PermissionForm,
        props: {
            pageTitle: 'permission.label.update_permission',
        },
    },
    // role
    {
        path: '/admin/auth/roles',
        name: 'admin.roles.index',
        component: Role,
    },
    {
        path: '/admin/auth/roles/create',
        name: 'admin.roles.create',
        component: RoleForm,
        props: {
            pageTitle: 'role.label.create_role',
        },
    },

    {
        path: '/admin/auth/roles/:roleId/edit',
        name: 'admin.roles.edit',
        component: RoleForm,
        props: {
            pageTitle: 'role.label.update_role',
        },
    },


    {
        path: '/admin/auth/quan-tri',
        name: 'admin.admins.index',
        component: AdminList,
    },
    {
        path: '/admin/auth/quan-tri/create',
        name: 'admin.admins.create',
        component: AdminForm,
        props: {
            pageTitle: 'user.label.create_admin',
        },
    },

    {
        path: '/admin/auth/quan-tri/:userId/edit',
        name: 'admin.admins.edit',
        component: AdminForm,
        props: {
            pageTitle: 'user.label.update_admin',
        },
    },


    {
        path: '/admin/device',
        name: 'admin.device.index',
        component: DeviceList,
    },
    {
        path: '/admin/device/create',
        name: 'admin.device.create',
        component: DeviceForm,
        props: {
            pageTitle: 'device.label.create_device',
        },
    },

    {
        path: '/admin/device/:deviceId/edit',
        name: 'admin.device.edit',
        component: DeviceForm,
        props: {
            pageTitle: 'device.label.update_device',
        },
    },

    {
        path: '/admin/profile/edit',
        name: 'admin.profile.edit',
        component: ProfileForm,
        props: {
            pageTitle: 'user.label.profile',
        },
    },

    {
        path: '/admin/post',
        name: 'admin.post.index',
        component: PostList,
    },
    {
        path: '/admin/post/create',
        name: 'admin.post.create',
        component: PostForm,
        props: {
            pageTitle: 'post.label.create_post',
        },
    },

    {
        path: '/admin/post/:postId/edit',
        name: 'admin.post.edit',
        component: PostForm,
        props: {
            pageTitle: 'post.label.update_post',
        },
    },

];
