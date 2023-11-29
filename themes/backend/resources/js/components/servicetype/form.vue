<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">


                        <div class="float-left d-flex align-items-center">
                            <i class="el-icon-arrow-left f-icon-bound-breadcrumb mr-2" @click="gotoPage({name: 'admin.servicetype.index'})"></i>
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
                                    <span class="f-text-title pl-1"> Thông tin chung</span>
                                </div>

                                <el-form
                                         :rules="formRules"
                                         ref="modelForm"
                                         :model="modelForm"
                                         label-position="top"
                                         v-loading.body="loading"
                                >

                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('servicetype.label.code')"
                                                          prop="code"
                                                          :class="{'el-form-item is-error': form.errors.has('code') }">
                                                <el-input v-model="modelForm.code" size="small"
                                                placeholder="Nhập mã loại dịch vụ"
                                                ></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('code')"
                                                     v-text="form.errors.first('code')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-12">
                                            <el-form-item :label="$t('servicetype.label.name')"
                                                          prop="name"
                                                          :class="{'el-form-item is-error': form.errors.has('name') }">
                                                <el-input v-model="modelForm.name" size="small"
                                                          placeholder="Nhập tên loại dịch vụ"
                                                ></el-input>
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

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },

        data() {
            return {
                form: new Form(),
                loading: false,
                loadingPassword: false,
                formRules: {
                    name: [
                        { required: true, message: 'Bắt buộc' , trigger: 'submit'}
                    ],
                    code: [
                        { required: true, message: '' , trigger: 'submit'}
                    ],

                },
                modelForm: {
                    code: '',

                    name: '',
                    description: '',



                },

            };
        },
        methods: {

            onSubmit() {
                this.form = new Form(_.merge(this.modelForm, {}));
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$notify({
                            type: 'success',
                            title: this.$route.params.servicetypeId !== undefined? 'Cập nhật thành công': 'Thêm mới thành công',

                            message: response.message,
                        });
                        this.$router.push({name: 'admin.servicetype.index'});
                    })
                    .catch((error) => {

                        this.loading = false;
                        this.$notify.error({
                            title: this.$route.params.servicetypeId !== undefined? 'Cập nhật thất bại': 'Thêm mới thất bại',
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
                    this.$router.push({name: 'admin.servicetype.index'});
                }).catch(() => {

                });


            },


            fetchData() {


                let routeUri = '';
                if (this.$route.params.servicetypeId !== undefined) {
                    this.loading = true;
                    routeUri = route('api.servicetype.find', {servicetype: this.$route.params.servicetypeId});
                    window.axios.get(routeUri)
                        .then((response) => {
                            this.loading = false;

                            this.modelForm = response.data.data;
                            this.modelForm.is_new = false;

                        });
                } else {
                    this.modelForm.is_new = true;
                }
            },

            getRoute() {
                if (this.$route.params.servicetypeId !== undefined) {
                    return route('api.servicetype.update', {servicetype: this.$route.params.servicetypeId});
                }
                return route('api.servicetype.store');
            },


        },
        mounted() {
            this.fetchData();

        },
        computed: {}
    }
</script>

<style scoped>


</style>
