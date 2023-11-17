<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="float-left d-flex align-items-center">
                            <span class="f-breadcrumb">{{ $t(pageTitle) }}</span>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            <el-button class="btn btn-flat  btn-cancel " size="small"
                                       @click="onCancel()">
                                {{ $t('mon.button.cancel') }}
                            </el-button>
                            <el-button type="primary" @click="onSubmit()" size="small"
                                       :loading="loading" class="btn btn-flat  btn-primary">
                                {{ $t('mon.button.save') }}
                            </el-button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="f-box-title  d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z" fill="#252525"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z" fill="#252525"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z" fill="#252525"/>
                                    </svg>
                                    <span class="f-text-title pl-1  "> {{ $t('common.info') }}</span>
                                </div>

                                <el-form   :model="modelForm"
                                         label-position="top"
                                         ref="modelForm"
                                         :rules="formRules"
                                                 v-loading.body="loading"
                                        >
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <el-form-item :label="$t('role.label.name')" prop="name"
                                                                  :class="{'el-form-item is-error': form.errors.has( 'name') }">
                                                        <el-input v-model="modelForm.name"
                                                                  placeholder="Nhập tên vai trò"
                                                                  size="small"
                                                                  @focus="form.errors.clear('name')"></el-input>
                                                        <div class="el-form-item__error"
                                                             v-if="form.errors.has('name')"
                                                             v-text="form.errors.first('name')"></div>
                                                    </el-form-item>


                                                </div>
                                                <div class="col-12">
                                                    <el-form-item :label="$t('role.label.description')"
                                                                  :class="{'el-form-item is-error': form.errors.has( 'description') }">
                                                        <el-input v-model="modelForm.description" type="textarea"
                                                                  show-word-limit
                                                                  placeholder="Nhập mô tả"
                                                                  :autosize="{ minRows: 2, maxRows: 10}" maxlength="200"></el-input>
                                                        <div class="el-form-item__error"
                                                             v-if="form.errors.has('description')"
                                                             v-text="form.errors.first('description')"></div>
                                                    </el-form-item>
                                                </div>
                                            </div>
                                        </el-form>

                                        <role-permission   :current-permissions="modelForm.permissions" @update-permissions="onUpdatePermission" v-if = "load_done"/>

                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <role-user   :current_role_id="roleId"  @update-users="onUpdateUser"/>
                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

</template>

<script>
    import Form from 'form-backend-validation';
    import RolePermission from './role-permissions';
    import RoleUser from './role-users';

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },
        components: {
            RolePermission,
            RoleUser
        },
        data() {
            return {
                form: new Form(),
                loading: false,
                load_done: false,
                formRules: {
                    name: [
                        { required: true, message: '' ,   trigger: 'submit'}
                    ]
                },
                modelForm: {
                    id: '',
                    name: '',
                    description: '',
                    guard_name: 'web',
                    permissions: {},
                    users: [],

                },
                permissions: [],
                checkedPermissions: [],
                checkAll: false,
                isIndeterminate: true,
                roleId: null
            };
        },
        methods: {
            onSubmit() {
                let params = _.merge(this.modelForm);
                params.users = params.users.map(item => {return item.id});
                this.form = new Form(params);
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$notify({
                            type: 'success',
                            message: response.message,
                        });
                        if (this.$route.params.roleId !== undefined) {

                        } else {
                            this.$router.push({name: 'admin.roles.index'});
                        }

                    })
                    .catch((error) => {

                        this.loading = false;
                        this.$notify.error({
                            title: this.$t('mon.error.Title'),
                            message: this.getSubmitError(this.form.errors),
                        });
                    });
            },
            onCancel() {

                this.$confirm(this.$t('mon.cancel.Are you sure to cancel?'), {
                    confirmButtonText: this.$t('mon.cancel.Yes'),
                    cancelButtonText: this.$t('mon.cancel.No'),
                    type: 'warning'
                }).then(() => {
                    this.$router.push({name: 'admin.roles.index'});
                }).catch(() => {

                });


            },


            fetchData() {
                this.loading = true;
                let routeUri = '';
                if (this.$route.params.roleId !== undefined) {
                    routeUri = route('api.roles.find', {role: this.$route.params.roleId});
                } else {
                    routeUri = route('api.roles.find-new');
                }
                window.axios.get(routeUri)
                    .then((response) => {
                        this.loading = false;

                        this.modelForm = response.data.data;
                        this.load_done = true;
                    });
            },

            getRoute() {
                if (this.$route.params.roleId !== undefined) {
                    return route('api.roles.update', {role: this.$route.params.roleId});
                }
                return route('api.roles.store');
            },
            reloadRemoveTable() {
                this.$refs.removeTable.reloadData();
            },
            reloadAddTable() {
                this.$refs.addTable.reloadData();
            },
            onUpdatePermission(permissions) {
                this.modelForm.permissions = permissions
            },
            onUpdateUser(users) {
                this.modelForm.users = users
            }

        },
        created() {
            this.roleId = this.$route.params.roleId;
        },
        mounted() {
            this.fetchData();
        },
        computed: {}
    }
</script>

<style scoped>
    .box-permission-header {
        display: flex;
        align-content: center;

    }
</style>
