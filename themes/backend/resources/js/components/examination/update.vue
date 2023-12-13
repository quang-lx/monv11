<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">


                        <div class="float-left d-flex align-items-center">
                            <i class="el-icon-arrow-left f-icon-bound-breadcrumb mr-2"
                               @click="gotoPage({ name: 'admin.patientexamination.index' })"></i>
                            <span class="f-breadcrumb">{{ $t(pageTitle) }}</span>

                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="float-right">

                            <el-button size="small" class="btn btn-flat  btn-idic-red" v-if="modelForm.status == 'init'"
                                       @click="onStart()"  >
                                <span class="d-flex justify-content-between align-items-center" style="gap:5px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                                      <path d="M8.02087 13.5114L12.2492 10.1885C12.2775 10.1661 12.3003 10.1376 12.316 10.1051C12.3317 10.0726 12.3398 10.0369 12.3398 10.0009C12.3398 9.96477 12.3317 9.92915 12.316 9.89666C12.3003 9.86416 12.2775 9.83563 12.2492 9.81319L8.02087 6.48819C7.86395 6.3652 7.63281 6.47547 7.63281 6.6748V13.3227C7.63281 13.522 7.86395 13.6344 8.02087 13.5114Z" fill="white"/>
                                      <path d="M17.3013 1.51807H1.6942C1.31886 1.51807 1.01562 1.8213 1.01562 2.19664V17.8038C1.01562 18.1791 1.31886 18.4824 1.6942 18.4824H17.3013C17.6767 18.4824 17.9799 18.1791 17.9799 17.8038V2.19664C17.9799 1.8213 17.6767 1.51807 17.3013 1.51807ZM16.4531 16.9556H2.54241V3.04485H16.4531V16.9556Z" fill="white"/>
                                    </svg>
                                    Bắt đầu khám
                                </span>

                            </el-button>
                            <el-button size="small" class="btn btn-flat  btn-idic-orange" v-if="modelForm.status == 'processing'"
                                       @click="onFinish()"  >
                                <span class="d-flex justify-content-between align-items-center" style="gap:5px">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20" viewBox="0 0 19 20" fill="none">
                                      <path d="M13.4679 6.62842H12.4734C12.2571 6.62842 12.0514 6.73232 11.9242 6.91045L8.59067 11.5332L7.08085 9.43813C6.95362 9.26212 6.75005 9.1561 6.53163 9.1561H5.5371C5.39926 9.1561 5.31868 9.31302 5.39926 9.4254L8.04145 13.0897C8.10387 13.1768 8.18615 13.2478 8.28148 13.2968C8.37681 13.3457 8.48244 13.3713 8.58961 13.3713C8.69678 13.3713 8.80241 13.3457 8.89774 13.2968C8.99307 13.2478 9.07535 13.1768 9.13777 13.0897L13.6036 6.89773C13.6863 6.78534 13.6057 6.62842 13.4679 6.62842Z" fill="white"/>
                                      <path d="M9.5 0.5C4.25379 0.5 0 4.75379 0 10C0 15.2462 4.25379 19.5 9.5 19.5C14.7462 19.5 19 15.2462 19 10C19 4.75379 14.7462 0.5 9.5 0.5ZM9.5 17.8884C5.14442 17.8884 1.61161 14.3556 1.61161 10C1.61161 5.64442 5.14442 2.11161 9.5 2.11161C13.8556 2.11161 17.3884 5.64442 17.3884 10C17.3884 14.3556 13.8556 17.8884 9.5 17.8884Z" fill="white"/>
                                    </svg>
                                    Kết thúc khám
                                </span>

                            </el-button>

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

<!-- thông tin bệnh nhân-->
        <patient-info :model-form="modelForm.patient" :show_diagnose="false"></patient-info>
        <examination-info :examination_data="modelForm" :show_diagnose="false"/>
        <list-index-result :examination_id="modelForm.id" :patient_id="modelForm.parent_id" v-if="modelForm.id"/>

    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    import PatientInfo from './../patient/patient_info';
    import ExaminationInfo from './../patient/examination_info';
    import ListIndexResult from './list_index_result';

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },
        components: {
            PatientInfo,
            ExaminationInfo,
            ListIndexResult
        },

        data() {
            return {
                activeName: 'first',
                form: new Form(),
                loading: false,
                loadingPassword: false,
                formRules: {
                    name: [
                        {required: true, message: 'Bắt buộc', trigger: 'submit'}
                    ],
                    sex: [
                        {required: true, message: '', trigger: 'submit'}
                    ],
                    birthday: [
                        {required: true, message: '', trigger: 'submit'}
                    ],
                    phone: [
                        {required: true, message: '', trigger: 'submit'}
                    ]
                },
                modelForm: {
                    patient: {}
                },


            };
        },
        methods: {
            onSave() {


            },
            onSubmit() {

            },

            onCancel() {

                this.$confirm(this.$t('mon.cancel.Are you sure to cancel?'), {
                    confirmButtonText: this.$t('mon.cancel.Yes'),
                    cancelButtonText: this.$t('mon.cancel.No'),
                    type: 'warning'
                }).then(() => {
                    this.$router.push({name: 'admin.patientexamination.index'});
                }).catch(() => {

                });

            },

            fetchData() {
                let routeUri = '';
                if (this.$route.params.patientexaminationId !== undefined) {
                    this.loading = true;
                    routeUri = route('api.patientexamination.find', {patientexamination: this.$route.params.patientexaminationId});
                    window.axios.get(routeUri)
                        .then((response) => {
                            this.loading = false;
                            this.modelForm = response.data.data;
                        });
                }
            },


            getRoute($id) {
                if ($id) {
                    return route('api.patientexamination.update', {patientexamination: $id});
                }
                return route('api.patientexamination.store');
            },


            closePopup() {
                this.show_same_patient = false;
            },

            onStart() {
                window.axios.post(route('api.patientexamination.startExamination', {patientexamination: this.$route.params.patientexaminationId}))
                    .then((response) => {
                        if (!response.data.errors) {
                            this.$notify({
                                type: 'success',

                                message: response.data.message,
                            });
                            this.modelForm = response.data.model

                        } else {
                            this.$notify({
                                type: 'error',
                                message: response.data.message,
                            });
                        }
                    });
            },
            onFinish() {
                window.axios.post(route('api.patientexamination.finishExamination', {patientexamination: this.$route.params.patientexaminationId}))
                    .then((response) => {
                        if (!response.data.errors) {
                            this.$notify({
                                type: 'success',

                                message: response.data.message,
                            });

                            this.modelForm = response.data.model

                        } else {
                            this.$notify({
                                type: 'error',
                                message: response.data.message,
                            });
                        }
                    });
            }
        },
        mounted() {
            this.fetchData();

        },
        computed: {

        },
        watch: {
        }
    }
</script>

<style scoped>
    .btn-warning {
        color: #212529;
        background-color: #ffc107;
        border-color: #ffc107;
    }
</style>
