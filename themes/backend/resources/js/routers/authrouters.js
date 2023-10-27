import Permission from './../components/auth/permission/index.vue';
import PermissionForm from './../components/auth/permission/form.vue';

import Role from './../components/auth/role/index.vue';
import RoleForm from './../components/auth/role/form.vue';

import UserList from './../components/auth/user/index.vue';
import UserForm from './../components/auth/user/form.vue';

import AdminList from './../components/auth/admin/index.vue';
import AdminForm from './../components/auth/admin/form.vue';


import CategoryList from './../components/category/index.vue';
import CategoryForm from './../components/category/form.vue';

const currentLocale = '/' + window.MonCMS.currentLocale;

export default [
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
        path: '/admin/danh-muc',
        name: 'admin.category.index',
        component: CategoryList,
    },
    {
        path: '/admin/danh-muc/create',
        name: 'admin.category.create',
        component: CategoryForm,
        props: {
            pageTitle: 'category.label.create_category',
        },
    },

    {
        path: '/admin/danh-muc/:categoryId/edit',
        name: 'admin.category.edit',
        component: CategoryForm,
        props: {
            pageTitle: 'category.label.update_category',
        },
    },



];
