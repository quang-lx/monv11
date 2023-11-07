<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="float-left">
                            <el-breadcrumb separator="">
                                <el-breadcrumb-item :to="{name: 'admin.roles.index'}"><i class="el-icon-arrow-left"></i>
                                </el-breadcrumb-item>
                                <el-breadcrumb-item> {{ $t(pageTitle) }}
                                </el-breadcrumb-item>
                            </el-breadcrumb>
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
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title">
                                    {{ $t('common.info') }}
                                </h3>
                                <div class="card-tools">

                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <el-form ref="form" :model="modelForm"   label-position="top"
                                                 v-loading.body="loading"
                                        >
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <el-form-item :label="$t('permission.label.name')"
                                                                  :class="{'el-form-item is-error': form.errors.has( 'name') }">
                                                        <el-input v-model="modelForm.name"
                                                                  size="medium"
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
                                                                  :autosize="{ minRows: 2, maxRows: 10}" maxlength="200"></el-input>
                                                        <div class="el-form-item__error"
                                                             v-if="form.errors.has('description')"
                                                             v-text="form.errors.first('description')"></div>
                                                    </el-form-item>
                                                </div>
                                            </div>
                                        </el-form>

                                        <role-permission v-model="modelForm.permissions"
                                                                 :current-permissions="modelForm.permissions"/>

                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title">
                                    {{ $t('role.label.tab user') }}
                                </h3>
                                <div class="card-tools">

                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">


                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>

</template>

<script>
    import axios from 'axios';
    import Form from 'form-backend-validation';
    import RolePermission from './role-permissions';

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },
        components: {
            RolePermission
        },
        data() {
            return {
                form: new Form(),
                loading: false,
                modelForm: {
                    id: '',
                    name: '',
                    description: '',
                    guard_name: 'web',
                    permissions: {},

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
                this.form = new Form(_.merge(this.modelForm));
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$message({
                            type: 'success',
                            message: response.message,
                        });
                        this.$router.push({name: 'admin.roles.index'});
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
