<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">


                        <div class="float-left d-flex align-items-center">
                            <i class="el-icon-arrow-left f-icon-bound-breadcrumb mr-2" @click="gotoPage({name: 'admin.admins.index'})"></i>
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
                                    <span class="f-text-title pl-1"> Thông tin người dùng</span>
                                </div>

                                <el-form
                                         :rules="userRules"
                                         ref="modelForm"
                                         :model="modelForm"
                                         label-position="top"
                                         v-loading.body="loading"
                                >

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.name')"
                                                          prop="name"
                                                          :class="{'el-form-item is-error': form.errors.has('name') }">
                                                <el-input v-model="modelForm.name" size="small"
                                                placeholder="Nhập họ và tên"
                                                ></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('name')"
                                                     v-text="form.errors.first('name')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.sex')"
                                                          prop="sex"
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
                                                          placeholder="Nhập email"
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
                                                          placeholder="Nhập số điện thoại"
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
                                                          placeholder="Nhập giấy tờ tuỳ thân"
                                                          autocomplete="off"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('identification')"
                                                     v-text="form.errors.first('identification')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.department_id')"
                                                          prop="department_id"
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
                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('user.label.birth_day')"
                                                          :class="{'el-form-item is-error': form.errors.has('birth_day') }">

                                                <el-date-picker
                                                    v-model="modelForm.birth_day"
                                                    type="date"
                                                    style="width: 100%"
                                                    size="small"
                                                    format="dd/MM/yyyy"
                                                    value-format="yyyy-MM-dd"
                                                    placeholder="Chọn năm sinh">
                                                </el-date-picker>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('birth_day')"
                                                     v-text="form.errors.first('birth_day')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-4">
                                            <el-form-item label="Thời gian hiệu lực của tài khoản"
                                                          prop="active_at"
                                                          :class="{'el-form-item is-error': form.errors.has('active_at') }">
                                                <div class="row">
                                                    <div class="col-md-6 d-flex">
                                                        <span class="mr-2">Từ</span>
                                                        <el-date-picker
                                                            v-model="modelForm.active_at"
                                                            type="date"
                                                            style="width: 80%"
                                                            size="small"
                                                            format="dd/MM/yyyy"
                                                            value-format="yyyy-MM-dd"
                                                            placeholder="dd/mm/yyyy">
                                                    </el-date-picker>
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <span class="mr-2">Đến</span>
                                                        <el-date-picker
                                                            v-model="modelForm.expired_at"
                                                            type="date"
                                                            style="width: 80%"
                                                            size="small"
                                                            format="dd/MM/yyyy"
                                                            value-format="yyyy-MM-dd"
                                                            placeholder="dd/mm/yyyy">
                                                        </el-date-picker>
                                                    </div>
                                                </div>


                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('active_at')"
                                                     v-text="form.errors.first('active_at')"></div>
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

                            <div class="card-body">
                                <div class="f-box-title d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z" fill="#252525"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z" fill="#252525"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z" fill="#252525"/>
                                    </svg>
                                    <span class="f-text-title pl-1 "> Tài khoản đăng nhập</span>
                                </div>

                                <el-form ref="form"
                                         :model="modelForm"
                                         label-position="top"
                                         v-loading.body="loading"
                                >
                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item label="Tài khoản đăng nhập"
                                                          :class="{'el-form-item is-error': form.errors.has('username') }">
                                                <div class="row">
                                                    <div class="col-sm-9">
                                                        <el-input v-model="modelForm.username" :disabled="!modelForm.is_new"
                                                                  placeholder="Nhập tài khoản đăng nhập"
                                                                  size="small"
                                                                  autocomplete="off"></el-input>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <el-button type="primary" plain @click="onResetPassword" size="small" :loading="loadingPassword" v-if="!modelForm.is_new">Reset mật khẩu</el-button>

                                                    </div>
                                                </div>

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
                userRules: {
                    username: [
                        { required: true, message: 'Bắt buộc' , trigger: 'submit'}
                    ],
                    sex: [
                        { required: true, message: '' , trigger: 'submit'}
                    ],
                    name: [
                        { required: true, message: '', trigger: 'submit' }
                    ],
                    department_id: [
                        { required: true, message: '', trigger: 'submit' }
                    ],
                    active_at: [
                        { required: true, message: '' , trigger: 'submit'}
                    ],
                    expired_at: [
                        { required: true, message: '' , trigger: 'submit'}
                    ],
                },
                modelForm: {
                    username: '',
                    name: '',
                    sex: '',
                    phone: '',
                    email: '',
                    identification: '',
                    active_at: '',
                    expired_at: '',
                    birth_day: '',
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
            onResetPassword() {
                this.changepassForm = new Form();
                this.loadingPassword = true;

                this.changepassForm.post(route('api.users.reset-password', {user: this.$route.params.userId}))
                    .then((response) => {
                        this.loadingPassword = false;
                        this.$message({
                            type: 'success',
                            message: response.message,
                        });
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
