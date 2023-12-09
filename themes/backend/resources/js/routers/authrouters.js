import Permission from './../components/auth/permission/index.vue';
import PermissionForm from './../components/auth/permission/form.vue';

import Role from './../components/auth/role/index.vue';
import RoleForm from './../components/auth/role/form.vue';

import ServiceList from './../components/testingservice/index.vue';
import ServiceForm from './../components/testingservice/form.vue';

import AdminList from './../components/auth/admin/index.vue';
import AdminForm from './../components/auth/admin/form.vue';


import DeviceList from './../components/device/index.vue';
import DeviceForm from './../components/device/form.vue';

import DiseaseList from './../components/disease/index.vue';
import DiseaseForm from './../components/disease/form.vue';

import ServiceTypeList from './../components/servicetype/index.vue';
import ServiceTypeForm from './../components/servicetype/form.vue';
import PatientList from './../components/patient/index.vue';
import PatientCreate from './../components/patient/create.vue';
import PatientUpdate from './../components/patient/update.vue';

import ProfileForm from './../components/auth/profile/form.vue';

import ExaminationList from './../components/examination/index.vue';
import ExaminationForm from './../components/examination/update.vue';

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
        path: '/admin/service',
        name: 'admin.service.index',
        component: ServiceList,
    },
    {
        path: '/admin/service/create',
        name: 'admin.service.create',
        component: ServiceForm,
        props: {
            pageTitle: 'service.label.create_service',
        },
    },

    {
        path: '/admin/service/:testingserviceId/edit',
        name: 'admin.service.edit',
        component: ServiceForm,
        props: {
            pageTitle: 'service.label.update_service',
        },
    },

    {
        path: '/admin/disease',
        name: 'admin.disease.index',
        component: DiseaseList,
    },
    {
        path: '/admin/disease/create',
        name: 'admin.disease.create',
        component: DiseaseForm,
        props: {
            pageTitle: 'disease.label.create_disease',
        },
    },

    {
        path: '/admin/disease/:diseaseId/edit',
        name: 'admin.disease.edit',
        component: DiseaseForm,
        props: {
            pageTitle: 'disease.label.update_disease',
        },
    },

    {
        path: '/admin/patient',
        name: 'admin.patient.index',
        component: PatientList,
    },
    {
        path: '/admin/patient/create',
        name: 'admin.patient.create',
        component: PatientCreate,
        props: {
            pageTitle: 'patient.label.create_patient',
        },
    },

    {
        path: '/admin/patient/:patientId/edit',
        name: 'admin.patient.edit',
        component: PatientUpdate,
        props: {
            pageTitle: 'patient.label.update_patient',
        },
    },


    {
        path: '/admin/servicetype',
        name: 'admin.servicetype.index',
        component: ServiceTypeList,
    },
    {
        path: '/admin/servicetype/create',
        name: 'admin.servicetype.create',
        component: ServiceTypeForm,
        props: {
            pageTitle: 'servicetype.label.create_servicetype',
        },
    },

    {
        path: '/admin/servicetype/:servicetypeId/edit',
        name: 'admin.servicetype.edit',
        component: ServiceTypeForm,
        props: {
            pageTitle: 'servicetype.label.update_servicetype',
        },
    },

    {
        path: '/admin/kham-benh',
        name: 'admin.patientexamination.index',
        component: ExaminationList,
    },


    {
        path: '/admin/kham-benh/:patientexaminationId/cap-nhat',
        name: 'admin.patientexamination.edit',
        component: ExaminationForm,
        props: {
            pageTitle: 'examination.label.update_label',
        },
    },



];
