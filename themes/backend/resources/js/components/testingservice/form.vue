<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">


                        <div class="float-left d-flex align-items-center">
                            <i class="el-icon-arrow-left f-icon-bound-breadcrumb mr-2" @click="gotoPage({name: 'admin.service.index'})"></i>
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
                                            <el-form-item :label="$t('service.label.code')"
                                                          prop="code"
                                                          :class="{'el-form-item is-error': form.errors.has('code') }">
                                                <el-input v-model="modelForm.code" size="small"
                                                placeholder="Nhập mã dịch vụ"
                                                ></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('code')"
                                                     v-text="form.errors.first('code')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.code_lis')"
                                                          prop="code_lis"
                                                          :class="{'el-form-item is-error': form.errors.has('code_lis') }">
                                                <el-input v-model="modelForm.code_lis" size="small"
                                                          placeholder="Nhập mã dịch vụ gửi LIS"
                                                ></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('code_lis')"
                                                     v-text="form.errors.first('code_lis')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.name')"
                                                          prop="name"
                                                          :class="{'el-form-item is-error': form.errors.has('name') }">
                                                <el-input v-model="modelForm.name" size="small"
                                                          placeholder="Nhập tên dịch vụ"
                                                ></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('name')"
                                                     v-text="form.errors.first('name')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.type')"
                                                          prop="type"
                                                          :class="{'el-form-item is-error': form.errors.has('type') }">
                                                <el-select v-model="modelForm.type"
                                                           filterable
                                                           placeholder="Chọn loại dịch vụ" style="width: 100%" size="small">
                                                    <el-option v-for="item in list_service_type" :key="item.id" :label="item.name"
                                                               :value="item.id">
                                                    </el-option>
                                                </el-select>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('type')"
                                                     v-text="form.errors.first('type')"></div>
                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('min_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.min_value" size="small"
                                                                 style="width: 100%"
                                                          placeholder="Nhập Trẻ em thấp"
                                                          autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('min_value')"
                                                     v-text="form.errors.first('min_value')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('max_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.max_value" size="small"
                                                          placeholder="Nhập Trẻ em cao"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('max_value')"
                                                     v-text="form.errors.first('max_value')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.ref_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('ref_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.ref_value" size="small"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('ref_value')"
                                                     v-text="form.errors.first('ref_value')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.unit')"
                                                          :class="{'el-form-item is-error': form.errors.has('unit') }">
                                                <el-input v-model="modelForm.unit" size="small"
                                                          autocomplete="off"></el-input>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('unit')"
                                                     v-text="form.errors.first('unit')"></div>
                                            </el-form-item>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.male_min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('male_min_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.male_min_value" size="small"
                                                          placeholder="Nhập giá nam trị thấp"
                                                                 style="width: 100%; text-align: left"
                                                                 autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('male_min_value')"
                                                     v-text="form.errors.first('male_min_value')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.male_max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('male_max_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.male_max_value" size="small"
                                                          placeholder="Nhập giá trị nam cao"
                                                                 style="width: 100%; text-align: left"
                                                                 autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('male_max_value')"
                                                     v-text="form.errors.first('male_max_value')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.female_min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('female_min_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.female_min_value" size="small"
                                                          placeholder="Nhập giá trị nữ thấp"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('female_min_value')"
                                                     v-text="form.errors.first('female_min_value')"></div>
                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.female_max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('female_max_value') }">
                                                <el-input-number :controls="false" v-model="modelForm.female_max_value" size="small"
                                                          placeholder="Nhập giá trị nữ cao"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input-number>
                                                <div class="el-form-item__error"
                                                     v-if="form.errors.has('female_max_value')"
                                                     v-text="form.errors.first('female_max_value')"></div>
                                            </el-form-item>
                                        </div>
                                    </div>



                                </el-form>
                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>

                <div class="row" v-if="!is_new">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <div class="f-box-title  d-flex align-items-center">
                                    <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.751357 0.494751H19.2514C19.5304 0.494751 19.7566 0.720965 19.7566 1.00001V14.75C19.7566 15.0291 19.5304 15.2553 19.2514 15.2553H0.751357C0.472308 15.2553 0.246094 15.0291 0.246094 14.75V1.00001C0.246094 0.720965 0.472308 0.494751 0.751357 0.494751ZM18.7459 14.2445V1.50526H1.25661V14.2445H18.7459Z" fill="#252525"/>
                                        <path d="M2.99609 8.50289L3.00091 7.49237L17.0114 7.55908L17.0066 8.5696L2.99609 8.50289Z" fill="#252525"/>
                                        <path d="M2.99609 10.5648L3.00091 9.55426L17.0114 9.62097L17.0066 10.6315L2.99609 10.5648Z" fill="#252525"/>
                                        <path d="M2.99609 12.6267L3.00091 11.6162L17.0114 11.6829L17.0066 12.6934L2.99609 12.6267Z" fill="#252525"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.50136 2.99475H9.75136C10.0304 2.99475 10.2566 3.22096 10.2566 3.50001V6.00001C10.2566 6.27906 10.0304 6.50528 9.75136 6.50528H3.50136C3.22231 6.50528 2.99609 6.27906 2.99609 6.00001V3.50001C2.99609 3.22096 3.22231 2.99475 3.50136 2.99475ZM9.24586 5.49451V4.00526H4.00661V5.49451H9.24586Z" fill="#252525"/>
                                    </svg>

                                    <span class="f-text-title pl-1"> Chỉ số con</span>
                                </div>

                                <service-index  :service_id="$route.params.testingserviceId" @update-service-index="onUpdateServiceIndex"></service-index>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>


    </div>


</template>

<script>
    import Form from 'form-backend-validation';
    import ServiceIndex from './serviceindex';
    import _ from "lodash";

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },
        components: {
            ServiceIndex
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
                    code_lis: [
                        { required: true, message: '' , trigger: 'submit'}
                    ],
                    type: [
                        { required: true, message: '' , trigger: 'submit'}
                    ]
                },
                modelForm: {
                    code: '',
                    code_lis: '',
                    name: '',
                    type: '',
                    min_value: undefined,
                    max_value: undefined,
                    ref_value: undefined,
                    unit: '',
                    male_min_value: undefined,
                    male_max_value: undefined,
                    female_min_value: undefined,
                    female_max_value: undefined,
                    list_service_index: []




                },
                list_service_type: []

            };
        },
        methods: {
            onUpdateServiceIndex(list_service_index) {
                this.modelForm.list_service_index = list_service_index
            },
            onSubmit() {
                this.form = new Form(_.merge(this.modelForm, {}));
                this.loading = true;

                this.form.post(this.getRoute())
                    .then((response) => {
                        this.loading = false;
                        this.$notify({
                            type: 'success',
                            title: this.$route.params.testingserviceId !== undefined? 'Cập nhật thành công': 'Thêm mới thành công',

                            message: response.message,
                        });
                        if(this.is_new) {
                            window.location.href= route('admin.serviceindex.edit', {testingservice: response.id})
                        }
                    })
                    .catch((error) => {

                        this.loading = false;
                        this.$notify.error({
                            title: this.$route.params.testingserviceId !== undefined? 'Cập nhật thất bại': 'Thêm mới thất bại',
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
                    this.$router.push({name: 'admin.service.index'});
                }).catch(() => {

                });


            },


            fetchData() {


                let routeUri = '';
                if (this.$route.params.testingserviceId !== undefined) {
                    this.loading = true;
                    routeUri = route('api.service.find', {testingservice: this.$route.params.testingserviceId});
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
                if (this.$route.params.testingserviceId !== undefined) {
                    return route('api.service.update', {testingservice: this.$route.params.testingserviceId});
                }
                return route('api.service.store');
            },

            getServiceType() {

                const properties = {
                    page: 1,
                    per_page: 10000

                };

                window.axios.get(route('api.servicetype.index', properties))
                    .then((response) => {

                        this.list_service_type = response.data.data;

                    });
            },


        },
        mounted() {
            this.getServiceType();
            this.fetchData();

        },
        computed: {
            is_new: function () {
                return this.$route.params.testingserviceId === undefined;
            }
        }
    }
</script>

<style scoped>


</style>
