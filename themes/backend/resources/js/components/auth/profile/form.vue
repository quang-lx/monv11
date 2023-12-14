<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <el-breadcrumb separator="/">
                            <el-breadcrumb-item>
                                <a href="/admin">{{ $t('mon.breadcrumb.home') }}</a>
                            </el-breadcrumb-item>
                            <el-breadcrumb-item :to="{ name: 'admin.users.index' }">{{ $t('user.label.users') }}
                            </el-breadcrumb-item>
                            <el-breadcrumb-item> {{ $t(pageTitle) }}
                            </el-breadcrumb-item>
                        </el-breadcrumb>
                    </div>

                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-3">
                        <div class="card">
                            <div class="card-body card-info-user text-center">
                                <div class="demo-type text-center">


                                    <el-upload :size="192" class="upload-demo" :action="uploadUrl"
                                        :on-success="handleSuccess" :show-file-list="false" :http-request="uploadFile"
                                        :multiple="true">
                                        <el-avatar :size="192" :src="modelForm.avatar_url">

                                        </el-avatar>
                                    </el-upload>
                                </div>
                                <div class="name">
                                    {{ modelForm.name }}
                                </div>

                                <div class="user

">
                                    {{ modelForm.username }}
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card">
                            <div class="card-body card-info-user card-form">
                                <div class="d-flex justify-content-between title">
                                    <h2>
                                        Thông tin cá nhân
                                    </h2>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-end">
                                            <el-button class="btn btn-flat btn-cancel" size="small" @click="onCancel()">
                                                {{ $t('mon.button.cancel') }}
                                            </el-button>

                                            <el-button type="primary" @click="onSubmit()" size="small" :loading="loading"
                                                class="btn btn-flat btn-primary">
                                                {{ $t('mon.button.update') }}
                                            </el-button>

                                            <el-button type="danger" size="small" class="btn btn-flat btn-change-pass"
                                                @click="changePassDialogVisible = true">
                                                {{ $t('user.label.change_password') }}
                                            </el-button>
                                        </div>
                                    </div>
                                </div>
                                <el-dialog class="popup-change-pass" custom-class="change-pass"
                                    :visible.sync="changePassDialogVisible" :show-close="true"
                                    :before-close="closeChangePass" width="500px">
                                    <h2>Đổi mật khẩu</h2>
                                    <p class="rule">
                                        Mật khẩu phải có tối thiểu 8 ký tự, gồm cả chữ hoa, chữ thường , số và ký tự đặc
                                        biệt:
                                    </p>
                                    <el-form ref="changepassForm" :model="modelFormPass" size="small" label-width="200px"
                                        label-position="top" v-loading.body="loadingPassword">
                                        <el-form-item class="formPassword"
                                            :class="{ 'el-form-item is-error': changepassForm.errors.has('password_old') }">
                                            <label class="el-form-item__label" for="">{{ $t('user.label.password_old')
                                            }}<span class="text-danger"> *</span></label>
                                            <el-input maxlength="255" v-model="modelFormPass.password_old"
                                                autocomplete="off" placeholder="Vui lòng nhập mật khẩu"
                                                :type="show_password_old ? 'text' : 'password'"></el-input>
                                            <!-- <div class="el-form-item__error" v-if="changepassForm.errors.has('password_old')"
                                                v-text="changepassForm.errors.first('password_old')"></div> -->
                                            <img role="button" class="show-hide-pass"
                                                @click="show_password_old = !show_password_old" src="/images/eye.svg" alt=""
                                                srcset="">
                                        </el-form-item>
                                        <el-form-item class="formPassword"
                                            :class="{ 'el-form-item is-error': changepassForm.errors.has('password_new') }">
                                            <label class="el-form-item__label" for="">{{ $t('user.label.password_new')
                                            }}<span class="text-danger"> *</span></label>

                                            <el-input maxlength="255" v-model="modelFormPass.password_new"
                                                autocomplete="off" placeholder="Vui lòng nhập mật khẩu"
                                                :type="show_password_new ? 'text' : 'password'"></el-input>
                                            <!-- <div class="el-form-item__error"
                                                v-if="changepassForm.errors.has('password_new')"
                                                v-text="changepassForm.errors.first('password_new')"></div> -->
                                            <img role="button" class="show-hide-pass"
                                                @click="show_password_new = !show_password_new" src="/images/eye.svg" alt=""
                                                srcset="">
                                        </el-form-item>
                                        <el-form-item class="formPassword"
                                            :class="{ 'el-form-item is-error': changepassForm.errors.has('password_confirmation') }">
                                            <label class="el-form-item__label" for="">{{
                                                $t('user.label.password_confirmation') }}<span class="text-danger">
                                                    *</span></label>
                                            <el-input maxlength="255" v-model="modelFormPass.password_confirmation"
                                                autocomplete="off" placeholder="Vui lòng xác nhận mật khẩu"
                                                :type="show_password_confirmation ? 'text' : 'password'"></el-input>
                                            <img role="button" class="show-hide-pass"
                                                @click="show_password_confirmation = !show_password_confirmation"
                                                src="/images/eye.svg" alt="" srcset="">

                                            <!-- <div class="el-form-item__error"
                                                v-if="changepassForm.errors.has('password_confirmation')"
                                                v-text="changepassForm.errors.first('password_confirmation')"></div> -->
                                        </el-form-item>
                                    </el-form>

                                    <span slot="footer" class="dialog-footer">
                                        <el-button type="primary" @click="changePassword">{{ $t('user.label.save_pass')
                                        }}</el-button>
                                    </span>
                                </el-dialog>
                                <el-form ref="form" :model="modelForm" label-width="200px" size="small" label-position="top"
                                    v-loading.body="loading">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <el-form-item :label="$t('user.label.username')"
                                                :class="{ 'el-form-item is-error': form.errors.has('username') }">
                                                <el-input maxlength="255" :disabled="true" v-model="modelForm.username"
                                                    autocomplete="off"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('username')"
                                                    v-text="form.errors.first('username')"></div>
                                            </el-form-item>

                                            <el-form-item :label="$t('user.label.sex')"
                                                :class="{ 'el-form-item is-error': form.errors.has('sex') }">
                                                <el-input maxlength="255" :disabled="true" v-model="modelForm.sex_text"
                                                    autocomplete="off"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('sex')"
                                                    v-text="form.errors.first('sex')"></div>
                                            </el-form-item>

                                            <el-form-item :label="$t('user.label.phone')"
                                                :class="{ 'el-form-item is-error': form.errors.has('phone') }">
                                                <el-input maxlength="255" v-model="modelForm.phone"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('phone')"
                                                    v-text="form.errors.first('phone')"></div>
                                            </el-form-item>

                                            <el-form-item :label="$t('user.label.birth_day')" prop="birth_day"
                                                :class="{ 'el-form-item is-error': form.errors.has('birth_day') }">
                                                <el-date-picker v-model="modelForm.birth_day" type="date" format="dd/MM/yyyy"
                                                    size="small" style="width: 100% !important;"
                                                    placeholder="Chọn ngày tháng năm sinh">
                                                </el-date-picker>
                                                <div class="el-form-item__error" v-if="form.errors.has('birth_day')"
                                                    v-text="form.errors.first('birth_day')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-6">

                                            <el-form-item :label="$t('user.label.name')"
                                                :class="{ 'el-form-item is-error': form.errors.has('name') }">
                                                <el-input maxlength="255" :disabled="true" v-model="modelForm.name"
                                                    autocomplete="off"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('name')"
                                                    v-text="form.errors.first('name')"></div>
                                            </el-form-item>

                                            <el-form-item :label="$t('user.label.department_id')"
                                                :class="{ 'el-form-item is-error': form.errors.has('department_id') }">
                                                <el-input maxlength="255" :disabled="true"
                                                    v-model="modelForm.department.name"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('department_id')"
                                                    v-text="form.errors.first('department_id')"></div>
                                            </el-form-item>

                                            <el-form-item :label="$t('user.label.email')"
                                                :class="{ 'el-form-item is-error': form.errors.has('email') }">
                                                <el-input maxlength="255" v-model="modelForm.email"
                                                    autocomplete="off"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('email')"
                                                    v-text="form.errors.first('email')"></div>
                                            </el-form-item>

                                            <el-form-item :label="$t('user.label.identification')"
                                                :class="{ 'el-form-item is-error': form.errors.has('identification') }">
                                                <el-input maxlength="255" v-model="modelForm.identification"
                                                    autocomplete="off"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('identification')"
                                                    v-text="form.errors.first('identification')"></div>
                                            </el-form-item>
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
import axios from 'axios';
import Form from 'form-backend-validation';

export default {
    props: {
        locales: { default: null },
        pageTitle: { default: null, String },
    },
    computed: {
        uploadUrl() {

            return route('api.users.uploadAvatar');
        },
        requestHeaders() {
            const userApiToken = document.head.querySelector('meta[name="user-api-token"]');
            return {
                Authorization: `Bearer ${userApiToken.content}`,
            };
        },
    },
    data() {
        return {
            form: new Form(),
            changepassForm: new Form(),
            loading: false,
            loadingPassword: false,
            show_password_confirmation: false,
            show_password_new: false,
            show_password_old: false,
            modelFormPass: {
                password_old: '',
                password_new: '',
                password_confirmation: ''
            },
            modelForm: {
                username: '',
                name: '',
                email: '',
                phone: '',
                roles: [],
                type: 2
            },
            roles: [],
            checkAll: false,
            isIndeterminate: true,
            changePassDialogVisible: false,
            imageUrl: ''
        };
    },
    methods: {
        onSubmit() {
            this.form = new Form(_.merge(this.modelForm, {}));
            this.loading = true;

            this.form.post(this.getRoute())
                .then((response) => {
                    this.loading = false;
                    this.$message({
                        type: 'success',
                        message: response.message,
                        showClose: true
                    });
                })
                .catch((error) => {

                    // this.loading = false;
                    // this.$notify.error({
                    //     message: this.getSubmitError(this.form.errors),
                    // });
                });
        },
        changePassword() {
            this.changepassForm = new Form({
                password_old: this.modelFormPass.password_old,
                password_new: this.modelFormPass.password_new,
                password_confirmation: this.modelFormPass.password_confirmation
            });
            this.loadingPassword = true;

            this.changepassForm.post(route('api.users.change-password', { user: this.modelForm.id }))
                .then((response) => {
                    this.loadingPassword = false;
                    this.$notify({
                        type: 'success',
                        message: response.message,
                    });
                    this.changePassDialogVisible = false;
                })
                .catch((error) => {
                    this.loadingPassword = false;
                    this.$message.error(this.getSubmitError(this.changepassForm.errors));
                });
        },
        onCancel() {

            this.$confirm(this.$t('mon.cancel.Are you sure to cancel?'), {
                confirmButtonText: this.$t('mon.cancel.Yes'),
                cancelButtonText: this.$t('mon.cancel.No'),
                type: 'warning'
            }).then(() => {
                this.fetchData();
                this.fetchRoles();
            }).catch(() => {

            });


        },


        fetchData() {
            let routeUri = '';
            this.loading = true;
            routeUri = route('api.users.profile');
            window.axios.get(routeUri)
                .then((response) => {
                    this.loading = false;
                    this.modelForm = response.data.data;
                    this.modelForm.is_new = false;
                });
        },

        fetchRoles() {
            window.axios.get(route('api.roles.all'))
                .then((response) => {
                    this.roles = response.data.data;
                });
        },
        getRoute() {
            return route('api.users.update', { user: this.modelForm.id });
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

        handleSuccess(response) {
            console.log(response)
        },
        uploadFile(event) {

            const data = new FormData();

            data.append('file', event.file);
            window.axios.post(route('api.users.uploadAvatar'), data)
                .then((response) => {
                    this.modelForm.avatar_url = response.data.data.full_url
                })
                .catch((error) => {
                    console.log(error.response.data);
                    this.fileIsUploading = false;
                    this.$notify.error({
                        title: 'Error',
                        message: error.response.data.errors.file[0],
                    });
                });
        },

        closeChangePass() {
            this.modelFormPass = {
                password_old: '',
                password_new: '',
                password_confirmation: ''
            }
            this.changepassForm = new Form()
            this.changePassDialogVisible = false
        }



    },
    mounted() {
        this.fetchData();
        this.fetchRoles();

    }

}
</script>

<style scoped>
.demo-type {
    margin-top: 64px;
}

.name {
    color: var(--gray-9, #2F3748);
    margin-top: 20px;
    /* Title/24/Medium */
    font-family: 'Roboto', sans-serif;
    font-size: 24px;
    font-style: normal;
    font-weight: 500;
    line-height: 32px;
    /* 133.333% */
}

.username {
    color: var(--gray-6, #64728E);

    /* Heading/16/Regular */
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 400;
    line-height: 24px;
    /* 150% */
}

.card-info-user {
    height: 405px;
}

.card-info-user h2 {
    color: var(--gray-9, #2F3748);

    /* Title/24/Medium */
    font-family: 'Roboto', sans-serif;
    font-size: 24px;
    font-style: normal;
    font-weight: 500;
    line-height: 36px;
    /* 150% */
}

.btn-change-pass {
    gap: 4px;
    border-radius: 4px;
    border: 1px solid var(--common-5, #0381FE);
    background: var(--common-1, #FFF);
    color: var(--common-5, #0381FE);
    font-size: 14px !important;
    /* 150% */
}

.card-form {
    padding: 32px !important;
}

.card-form .title {
    margin-bottom: 24px;
}

.popup-change-pass h2 {
    color: var(--basic-9, #25282B);

    /* Title/24/Bold */
    font-family: 'Roboto', sans-serif;
    font-size: 24px;
    font-style: normal;
    font-weight: 700;
    line-height: 32px;
    /* 133.333% */
}

.popup-change-pass .rule {
    color: var(--basic-5, #52575C);

    /* Body/14/Regular */
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px;
    /* 157.143% */
}

.dialog-footer button {
    width: 100%;
    display: flex;
    height: 48px;
    padding: 4px 16px;
    justify-content: center;
    align-items: center;
    gap: 4px;
    border-radius: 4px;
    background: var(--common-5, #0381FE);

}

.popup-change-pass label {
    padding-bottom: 0px;
}

.popup-change-pass .el-form-item {
    margin-bottom: 0px;
}

.formPassword {
    position: relative;
}

.formPassword img {
    position: absolute;
    top: 40px;
    right: 10px;
    width: 17px;
}
</style>


