<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">




                        <div class="float-left d-flex align-items-center">
                            <i class="el-icon-arrow-left f-icon-bound-breadcrumb mr-2"
                                @click="gotoPage({ name: 'admin.patient.index' })"></i>
                            <span class="f-breadcrumb">{{ $t(pageTitle) }}</span>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            <el-button size="small"  class="btn btn-flat  btn-warning" v-if="modelForm.status == 3" @click="onReExamination($route.params.patientId)">{{ $t('patient.label.re-examination') }}</el-button>

                            <el-button class="btn btn-flat  btn-cancel " size="small" @click="onCancel()">
                                {{ $t('mon.button.cancel') }}
                            </el-button>
                            <el-button type="primary" @click="onSubmit()" size="small" :loading="loading"
                                class="btn btn-flat  btn-primary">
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
                            <el-form :rules="formRules" ref="modelForm" :model="modelForm" label-position="top"
                                v-loading.body="loading">
                                <div class="card-body">

                                    <div class="f-box-title  d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z"
                                                fill="#252525" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z"
                                                fill="#252525" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z"
                                                fill="#252525" />
                                        </svg>
                                        <span class="f-text-title pl-1"> Thông tin bệnh nhân</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.name')" prop="name"
                                                :class="{ 'el-form-item is-error': form.errors.has('name') }">
                                                <el-input v-model="modelForm.name" size="small"
                                                    placeholder="Nhập họ và tên"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('name')"
                                                    v-text="form.errors.first('name')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.sex')" prop="sex"
                                                :class="{ 'el-form-item is-error': form.errors.has('sex') }">
                                                <el-select v-model="modelForm.sex" placeholder="Chọn giới tính" size = "small">
                                                    <el-option v-for="item in sexs" :key="item.value" :label="item.label"
                                                        :value="item.value">
                                                    </el-option>
                                                </el-select>
                                                <div class="el-form-item__error" v-if="form.errors.has('sex')"
                                                    v-text="form.errors.first('sex')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.birthday')" prop="birthday"

                                                :class="{ 'el-form-item is-error': form.errors.has('birthday') }">
                                                <el-date-picker v-model="modelForm.birthday" type="date" format="dd/MM/yyyy" size = "small"
                                                                style="width: 100% !important;"
                                                    placeholder="Chọn ngày tháng năm sinh">
                                                </el-date-picker>
                                                <div class="el-form-item__error" v-if="form.errors.has('birthday')"
                                                    v-text="form.errors.first('birthday')"></div>
                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.phone')" prop="phone"
                                                :class="{ 'el-form-item is-error': form.errors.has('phone') }">
                                                <el-input v-model="modelForm.phone" size="small"
                                                    placeholder="Nhập số điện thoại"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('phone')"
                                                    v-text="form.errors.first('phone')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.email')" prop="email"
                                                :class="{ 'el-form-item is-error': form.errors.has('email') }">
                                                <el-input v-model="modelForm.email" size="small"
                                                    placeholder="Nhập email"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('email')"
                                                    v-text="form.errors.first('email')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.papers')" prop="papers"
                                                :class="{ 'el-form-item is-error': form.errors.has('papers') }">
                                                <el-input v-model="modelForm.papers" size="small"
                                                    placeholder="Nhập giấy tờ tuỳ thân"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('papers')"
                                                    v-text="form.errors.first('papers')"></div>
                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.job')" prop="job"
                                                :class="{ 'el-form-item is-error': form.errors.has('job') }">
                                                <el-input v-model="modelForm.job" size="small"
                                                    placeholder="Nhập đơn vị làm việc hoặc nghề nghiệp"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('job')"
                                                    v-text="form.errors.first('job')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.address')" prop="address"
                                                :class="{ 'el-form-item is-error': form.errors.has('address') }">
                                                <el-input v-model="modelForm.address" size="small"
                                                    placeholder="Nhập địa chỉ"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('address')"
                                                    v-text="form.errors.first('address')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4" v-if="$route.params.patientId">
                                            <el-form-item :label="$t('patient.label.label status')" prop="status"
                                                :class="{ 'el-form-item is-error': form.errors.has('status') }">
                                                <el-input :disabled="$route.params.patientId"
                                                    v-model="modelForm.status_name" size="small"></el-input>
                                            </el-form-item>
                                        </div>

                                    </div>

                                    <div class="row" v-if="$route.params.patientId">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.created_at')" prop="created_at"
                                                :class="{ 'el-form-item is-error': form.errors.has('created_at') }">
                                                <el-input :disabled="$route.params.patientId"
                                                    v-model="modelForm.created_at" size="small"></el-input>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.created_by_info')"
                                                prop="created_by_info"
                                                :class="{ 'el-form-item is-error': form.errors.has('created_by_info') }">
                                                <el-input :disabled="$route.params.patientId"
                                                    v-model="modelForm.created_by_info" size="small"></el-input>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.label data_sources')"
                                                prop="data_sources"
                                                :class="{ 'el-form-item is-error': form.errors.has('data_sources') }">
                                                <el-input :disabled="$route.params.patientId"
                                                    v-model="modelForm.data_sources" size="small"></el-input>

                                            </el-form-item>
                                        </div>

                                    </div>


                                    <div class="f-box-title  d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z"
                                                fill="#252525" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z"
                                                fill="#252525" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z"
                                                fill="#252525" />
                                        </svg>
                                        <span class="f-text-title pl-1"> Thông tin người nhà</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.dependant')" prop="dependant"
                                                :class="{ 'el-form-item is-error': form.errors.has('dependant') }">
                                                <el-input v-model="modelForm.dependant" size="small"
                                                    placeholder="Nhập họ và tên"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('dependant')"
                                                    v-text="form.errors.first('dependant')"></div>
                                            </el-form-item>
                                        </div>

                                        <div class="col-md-4">
                                            <el-form-item :label="$t('patient.label.phone_dependant')"
                                                prop="phone_dependant"
                                                :class="{ 'el-form-item is-error': form.errors.has('phone_dependant') }">
                                                <el-input v-model="modelForm.phone_dependant" size="small"
                                                    placeholder="Nhập số điện thoại"></el-input>
                                                <div class="el-form-item__error" v-if="form.errors.has('phone_dependant')"
                                                    v-text="form.errors.first('phone_dependant')"></div>
                                            </el-form-item>
                                        </div>

                                    </div>

                                    <div class="f-box-title  d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                            fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z"
                                                fill="#252525" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z"
                                                fill="#252525" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z"
                                                fill="#252525" />
                                        </svg>
                                        <span class="f-text-title pl-1"> Thông tin khám bệnh</span>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <el-form-item :label="$t('patient.label.diagnose')" prop="diagnose"
                                                :class="{ 'el-form-item is-error': form.errors.has('diagnose') }">
                                                <el-input type="textarea" placeholder=""
                                                    :autosize="{ minRows: 5, maxRows: 10 }"
                                                    v-model="modelForm.diagnose"></el-input>

                                                <div class="el-form-item__error" v-if="form.errors.has('diagnose')"
                                                    v-text="form.errors.first('diagnose')"></div>
                                            </el-form-item>
                                        </div>

                                    </div>
                                </div><!-- /.card-body -->
                            </el-form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <service-list :patient_id="$route.params.patientId"
                                    @update-service-list="onUpdateServiceList"></service-list>

                            </div><!-- /.card-body -->

                        </div>
                    </div>
                </div>

            </div>
        </section>


        <same-patient-create v-if="!this.$route.params.patientId" :show_same_patient="show_same_patient"
            :list_patient_same="list_patient_same" @on-create="onSubmit" @on-update="onReExamination"
            @close-popup="closePopup"></same-patient-create>

        <same-patient-update v-if="this.$route.params.patientId" :show_same_patient="show_same_patient"
            :list_patient_same="list_patient_same" @on-update="onSubmit" @close-popup="closePopup"></same-patient-update>

    </div>
</template>

<script>
import Form from 'form-backend-validation';
import ServiceList from './service_list';
import SamePatientCreate from './same_patient_create';
import SamePatientUpdate from './same_patient_update';

export default {
    props: {
        locales: { default: null },
        pageTitle: { default: null, String },
    },
    components: {
        ServiceList,
        SamePatientCreate,
        SamePatientUpdate
    },
    data() {
        return {
            form: new Form(),
            loading: false,
            loadingPassword: false,
            formRules: {
                name: [
                    { required: true, message: 'Bắt buộc', trigger: 'submit' }
                ],
                sex: [
                    { required: true, message: '', trigger: 'submit' }
                ],
                birthday: [
                    { required: true, message: '', trigger: 'submit' }
                ],
                phone: [
                    { required: true, message: '', trigger: 'submit' }
                ]
            },
            modelForm: {
                name: '',
                sex: '',
                birthday: '',
                phone: '',
                email: '',
                papers: '',
                job: '',
                papers: '',
                list_service: []
            },

            value1: '',

            sexs: [
                {
                    value: 0,
                    label: 'Nữ'
                },
                {
                    value: 1,
                    label: 'Nam'
                }
            ],
            show_same_patient: false,
            list_patient_same: []
        };
    },
    methods: {
        onSubmit(is_agree = false) {
            this.modelForm.is_agree = is_agree;
            this.form = new Form(_.merge(this.modelForm, {}));
            this.loading = true;

            this.form.post(this.getRoute(this.$route.params.patientId))
                .then((response) => {
                    this.loading = false;
                    if (response.errors) {
                        this.show_same_patient = true;
                        this.list_patient_same = response.list_patient_same
                        return;
                    }
                    this.$notify({
                        type: 'success',
                        title: this.$route.params.patientId !== undefined ? 'Cập nhật thành công' : 'Thêm mới thành công',
                        message: response.message,
                    });
                    this.$router.push({ name: 'admin.patient.index' });
                })
                .catch((error) => {

                    this.loading = false;
                    this.$notify.error({
                        title: this.$route.params.patientId !== undefined ? 'Cập nhật thất bại' : 'Thêm mới thất bại',
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
                this.$router.push({ name: 'admin.patient.index' });
            }).catch(() => {

            });

        },

        fetchData() {
            let routeUri = '';
            if (this.$route.params.patientId !== undefined) {
                this.loading = true;
                routeUri = route('api.patient.find', { patient: this.$route.params.patientId });
                window.axios.get(routeUri)
                    .then((response) => {
                        this.loading = false;
                        this.modelForm = response.data.data;
                    });
            }
        },

        onReExamination(id) {
            window.axios.post(route('api.patient.change_status'), { id: id, status: 1 })
                .then((response) => {
                    if (!response.data.errors) {
                        this.$notify({
                            type: 'success',
                            title: 'Tái khám thành công',
                            message: response.data.message,
                        });
                        this.$router.push({ name: 'admin.patient.index' });
                    } else {
                        this.$notify({
                            type: 'error',
                            title: 'Lỗi',
                            message: response.data.message,
                        });
                    }
                });
        },

        getRoute($id) {
            if ($id) {
                return route('api.patient.update', { patient: $id });
            }
            return route('api.patient.store');
        },

        onUpdateServiceList(list_service) {
            this.modelForm.list_service = list_service
        },

        closePopup() {
            this.show_same_patient = false;
        },


    },
    mounted() {
        this.fetchData();

    },
    computed: {}
}
</script>

<style scoped>
.btn-warning {
    color: #212529;
    background-color: #ffc107;
    border-color: #ffc107;
}
</style>
