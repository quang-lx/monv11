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
        <list-index-result />

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
