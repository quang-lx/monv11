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


                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- Main content -->

<!-- thông tin bệnh nhân-->
        <patient-info :model-form="modelForm.patient" :show_diagnose="false"></patient-info>
        <examination-result :examination_service="modelForm" ></examination-result>
        <examination-info :examination_data="modelForm" :show_diagnose="false" :show_status="true"/>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <el-form :model="modelForm" label-position="top">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <el-form-item :label="$t('patient.label.diagnose')" prop="diagnose"
                                                  :class="{ 'el-form-item is-error': form.errors.has('diagnose') }">
                                        <el-input type="textarea" placeholder="" disabled

                                                  :autosize="{ minRows: 5, maxRows: 10 }"
                                                  v-model="modelForm.diagnose"></el-input>

                                        <div class="el-form-item__error" v-if="form.errors.has('diagnose')"
                                             v-text="form.errors.first('diagnose')"></div>
                                    </el-form-item>
                                </div>

                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <service-list :patient_id="modelForm.patient_id"  v-if="load_done" :show_add_icon="false"></service-list>

                    </div><!-- /.card-body -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from 'form-backend-validation';
    import PatientInfo from './../patient/patient_info';
    import ExaminationInfo from './../patient/examination_info';
    import ListIndexResult from '../examination/list_index_result';
    import ServiceList from './../patient/service_list';
    import ExaminationResult from './examination_result';

    export default {
        props: {
            locales: {default: null},
            pageTitle: {default: null, String},
        },
        components: {
            PatientInfo,
            ExaminationInfo,
            ListIndexResult,
            ServiceList,
            ExaminationResult
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
                load_done: false,
                modelForm: {
                    id: '',
                    patient: {}
                },


            };
        },
        methods: {


            fetchData() {
                let routeUri = '';
                if (this.$route.params.examinationserviceId !== undefined) {
                    this.loading = true;
                    routeUri = route('api.examinationservice.find', {examinationservice: this.$route.params.examinationserviceId});
                    window.axios.get(routeUri)
                        .then((response) => {
                            this.loading = false;
                            this.modelForm = response.data.data;
                            this.load_done = true
                        });
                }
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
