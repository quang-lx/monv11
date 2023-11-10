<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="float-left">
                            <el-breadcrumb separator="">
                                <el-breadcrumb-item :to="{name: 'admin.admins.index'}"><i
                                    class="el-icon-arrow-left"></i>
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
                                    Thông tin người dùng
                                </h3>

                            </div><!-- /.card-header -->
                            <div class="card-body">

                                <el-form ref="form"
                                         :model="modelForm"
                                         label-position="top"
                                         v-loading.body="loading"
                                >

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.name')"
                                                          :class="{'el-form-item is-error': form.errors.has('name') }">
                                                <el-input v-model="modelForm.name" size="small"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('name')"
                                                     v-text="form.errors.first('name')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.sex')"
                                                          :class="{'el-form-item is-error': form.errors.has('sex') }">

                                                <el-select v-model="modelForm.sex" size="small"
                                                           :placeholder="$t('user.label.select sex')"
                                                           filterable style="width: 100% !important">
                                                    <el-option
                                                        v-for="item in listSex"
                                                        :key="'sex'+ item.value"
                                                        :label="item.label"
                                                        :value="item.value">
                                                    </el-option>

                                                </el-select>

                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('sex')"
                                                     v-text="form.errors.first('sex')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.email')"
                                                          :class="{'el-form-item is-error': form.errors.has('email') }">
                                                <el-input v-model="modelForm.email" size="small"
                                                          autocomplete="off"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('email')"
                                                     v-text="form.errors.first('email')"></div>
                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.phone')"
                                                          :class="{'el-form-item is-error': form.errors.has('phone') }">
                                                <el-input v-model="modelForm.phone" size="small"
                                                          autocomplete="off"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('phone')"
                                                     v-text="form.errors.first('phone')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.identification')"
                                                          :class="{'el-form-item is-error': form.errors.has('identification') }">
                                                <el-input v-model="modelForm.identification" size="small"
                                                          autocomplete="off"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('identification')"
                                                     v-text="form.errors.first('identification')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.department_id')"
                                                          :class="{'el-form-item is-error': form.errors.has('department_id') }">

                                                <el-select v-model="modelForm.department_id"
                                                           :placeholder="$t('user.label.select department')"
                                                           size="small"
                                                           filterable style="width: 100% !important">
                                                    <el-option
                                                        v-for="item in listDepartment"
                                                        :key="'sex'+ item.id"
                                                        :label="item.name"
                                                        :value="item.id">
                                                    </el-option>

                                                </el-select>

                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('department_id')"
                                                     v-text="form.errors.first('department_id')"></div>
                                            </el-form-item>
                                        </div>

                                    </div>


                                </el-form>
                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title">
                                    Tài khoản đăng nhâp
                                </h3>

                            </div><!-- /.card-header -->
                            <div class="card-body">

                                <el-form ref="form"
                                         :model="modelForm"
                                         label-position="top"
                                         v-loading.body="loading"
                                >
                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.username')"
                                                          :class="{'el-form-item is-error': form.errors.has('username') }">
                                                <el-input v-model="modelForm.username" :disabled="!modelForm.is_new"
                                                          size="small"
                                                          autocomplete="off"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('username')"
                                                     v-text="form.errors.first('username')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-12">
                                            <h6 class="mb-2">Vai trò quản trị</h6>
                                            <el-table
                                                ref="multipleTable"
                                                :data="roles"
                                                style="width: 100%"
                                                @selection-change="handleSelectionChange">
                                                <el-table-column
                                                    type="selection"
                                                    width="55">
                                                </el-table-column>

                                                <el-table-column
                                                    property="name"
                                                    label="Tên vai trò">
                                                </el-table-column>
                                                <el-table-column
                                                    property="description"
                                                    label="Mô tả"
                                                >
                                                </el-table-column>
                                            </el-table>

                                        </div>


                                    </div>
                                </el-form>
                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>

            </div>
        </section>


        <el-dialog
            :title="($t('user.label.change_password') + ': ' + modelForm.username)"
            :visible.sync="changePassDialogVisible"
            width="30%"
            center>
            <el-form ref="changepassForm"
                     :model="modelForm"
                     label-width="200px"
                     label-position="left"
                     v-loading.body="loadingPassword"
            >
                <el-form-item :label="$t('user.label.password_new')" style="margin-bottom:30px"
                              :class="{'el-form-item is-error': changepassForm.errors.has('password') }">
                    <el-input v-model="modelForm.password" autocomplete="off"
                              type="password"></el-input>
                    <div class="el-form-item__error"
                         v-if="changepassForm.errors.has('password')"
                         v-text="changepassForm.errors.first('password')"></div>
                </el-form-item>
                <el-form-item :label="$t('user.label.password_confirmation_new')"
                              :class="{'el-form-item is-error': changepassForm.errors.has('password_confirmation') }">
                    <el-input v-model="modelForm.password_confirmation" autocomplete="off"
                              type="password"></el-input>
                    <div class="el-form-item__error"
                         v-if="changepassForm.errors.has('password_confirmation')"
                         v-text="changepassForm.errors.first('password_confirmation')"></div>
                </el-form-item>
            </el-form>

            <span slot="footer" class="dialog-footer">
                                        <el-button @click="changePassDialogVisible = false">  {{$t('mon.button.cancel') }}</el-button>
                                        <el-button type="primary"
                                                   @click="changePassword"> {{ $t('mon.button.save') }}</el-button>
                                      </span>
        </el-dialog>

    </div>


</template>

<script>
    import Form from 'form-backend-validation';
    import SingleFileSelector from "../../../mixins/SingleFileSelector.js";

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },
        mixins: [SingleFileSelector],
        data() {
            return {
                form: new Form(),
                changepassForm: new Form(),
                loading: false,
                loadingPassword: false,
                modelForm: {
                    username: '',
                    name: '',
                    sex: '',
                    phone: '',
                    email: '',
                    identification: '',
                    department_id: null,
                    roles: [],
                    is_new: false,
                    type: 1

                },
                listDepartment: [],
                listSex: [

                    {
                        value: 'male',
                        label: 'Nam'
                    },
                    {
                        value: 'female',
                        label: 'Nữ'
                    }
                ],
                roles: [],
                checkAll: false,
                isIndeterminate: false,
                changePassDialogVisible: false
            };
        },
        methods: {
            toggleSelection() {
                let rows = this.roles.filter(item => {
                    return this.modelForm.roles.includes(item.id);
                });
                if (rows) {
                    rows.forEach(row => {
                        this.$refs.multipleTable.toggleRowSelection(row);
                    });
                }
            },
            handleSelectionChange(val) {
                this.modelForm.roles = val.map(item => {
                    return item.id
                });
            },
            onSubmit() {
                this.form = new Form(_.merge(this.modelForm, {}));
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;

                        window.location.href = route('admin.admins.index') + '?msg=' + response.message
                    })
                    .catch((error) => {

                        this.loading = false;
                        this.$notify.error({
                            title: this.$t('mon.error.Title'),
                            message: this.getSubmitError(this.form.errors),
                        });
                    });
            },
            changePassword() {
                this.changepassForm = new Form({
                    password: this.modelForm.password,
                    password_confirmation: this.modelForm.password_confirmation
                });
                this.loadingPassword = true;

                this.changepassForm.post(route('api.users.change-password', {user: this.$route.params.userId}))
                    .then((response) => {
                        this.loadingPassword = false;
                        this.$message({
                            type: 'success',
                            message: response.message,
                        });
                        this.changePassDialogVisible = false;
                    })
                    .catch((error) => {
                        this.loadingPassword = false;
                        this.$notify.error({
                            title: this.$t('mon.error.Title'),
                            message: this.getSubmitError(this.changepassForm.errors),
                        });
                    });
            },
            onCancel() {

                this.$confirm(this.$t('mon.cancel.Are you sure to cancel?'), {
                    confirmButtonText: this.$t('mon.cancel.Yes'),
                    cancelButtonText: this.$t('mon.cancel.No'),
                    type: 'warning'
                }).then(() => {
                    this.$router.push({name: 'admin.admins.index'});
                }).catch(() => {

                });


            },


            fetchData() {


                let routeUri = '';
                if (this.$route.params.userId !== undefined) {
                    this.loading = true;
                    routeUri = route('api.users.find', {user: this.$route.params.userId});
                    window.axios.get(routeUri)
                        .then((response) => {
                            this.loading = false;
                            this.modelForm = response.data.data;
                            this.modelForm.is_new = false;
                            this.toggleSelection();

                        });
                } else {
                    this.modelForm.is_new = true;
                }
            },

            fetchRoles() {
                window.axios.get(route('api.roles.all', {module: 'admin', per_page: 1000}))
                    .then((response) => {
                        this.roles = response.data.data;
                        this.fetchData();
                    });
            },
            getRoute() {
                if (this.$route.params.userId !== undefined) {
                    return route('api.users.update', {user: this.$route.params.userId});
                }
                return route('api.users.store');
            },
            handleCheckAllChange(val) {
                this.modelForm.roles = val ? this.roles.map(item => item.id) : [];
                this.isIndeterminate = false;
            },
            handleCheckedChange(value) {

                let checkedCount = value.length;
                this.checkAll = checkedCount === this.roles.length;
                this.isIndeterminate = checkedCount > 0 && checkedCount < this.roles.length;
            },
            getDepartmentHierarchy(customProperties) {

                const properties = {};
                window.axios.get(route('api.department.hierarchy', _.merge(properties, customProperties)))
                    .then((response) => {
                        this.listDepartment = response.data;

                    });
            },


        },
        mounted() {

            this.fetchRoles();
            this.getDepartmentHierarchy();

        },
        computed: {}
    }
</script>

<style scoped>

</style>
