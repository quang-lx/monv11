<template>
    <div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <el-form  :model="examination_data" label-position="top" >
                        <div class="card-body">
                            <div class="row"  >
                                <div class="col-12">
                                    <div class="f-box-title  d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                             viewBox="0 0 18 18"
                                             fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z"
                                                  fill="#252525"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z"
                                                  fill="#252525"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z"
                                                  fill="#252525"/>
                                        </svg>
                                        <span class="f-text-title pl-1"> Thông tin khám hiện tại</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="show_status" >
                                <div class="col-md-3">
                                    <el-form-item :label="$t('examination.label.started_at')"
                                                  prop="started_at"
                                                  :class="{ 'el-form-item is-error': form.errors.has('started_at') }">
                                        <el-input v-model="modelForm.started_at" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('started_at')"
                                             v-text="form.errors.first('started_at')"></div>
                                    </el-form-item>
                                </div>
                                <div class="col-md-3">
                                    <el-form-item :label="$t('examination.label.finished_at')"
                                                  prop="started_at"
                                                  :class="{ 'el-form-item is-error': form.errors.has('finished_at') }">
                                        <el-input v-model="modelForm.finished_at" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('finished_at')"
                                             v-text="form.errors.first('finished_at')"></div>
                                    </el-form-item>
                                </div>
                                <div class="col-md-3">
                                    <el-form-item :label="$t('examination.label.type')"
                                                  prop="started_at"
                                                  :class="{ 'el-form-item is-error': form.errors.has('type') }">
                                        <el-input v-model="modelForm.type_text" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('type')"
                                             v-text="form.errors.first('type')"></div>
                                    </el-form-item>
                                </div>
                                <div class="col-md-3">
                                    <el-form-item :label="$t('examination.label.status')"
                                                  prop="started_at"
                                                  :class="[{ 'el-form-item is-error': form.errors.has('status') }, modelForm.status_class]">
                                        <el-input v-model="modelForm.status_text" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('status')"
                                             v-text="form.errors.first('status')"></div>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row" v-else >
                                <div class="col-md-4">
                                    <el-form-item :label="$t('examination.label.started_at')"
                                                  prop="started_at"
                                                  :class="{ 'el-form-item is-error': form.errors.has('started_at') }">
                                        <el-input v-model="modelForm.started_at" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('started_at')"
                                             v-text="form.errors.first('started_at')"></div>
                                    </el-form-item>
                                </div>
                                <div class="col-md-4">
                                    <el-form-item :label="$t('examination.label.finished_at')"
                                                  prop="started_at"
                                                  :class="{ 'el-form-item is-error': form.errors.has('finished_at') }">
                                        <el-input v-model="modelForm.finished_at" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('finished_at')"
                                             v-text="form.errors.first('finished_at')"></div>
                                    </el-form-item>
                                </div>
                                <div class="col-md-4">
                                    <el-form-item :label="$t('examination.label.type')"
                                                  prop="started_at"
                                                  :class="{ 'el-form-item is-error': form.errors.has('type') }">
                                        <el-input v-model="modelForm.type_text" size="small"
                                                  disabled
                                        ></el-input>
                                        <div class="el-form-item__error"
                                             v-if="form.errors.has('type')"
                                             v-text="form.errors.first('type')"></div>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" v-if="show_diagnose">
                                    <el-form-item :label="$t('examination.label.disease_id')" prop="disease_id"
                                                  :class="{ 'el-form-item is-error': form.errors.has('disease_id') }">

                                        <el-input  placeholder=""
                                                  disabled

                                                  v-model="modelForm.display_text"></el-input>


                                        <div class="el-form-item__error" v-if="form.errors.has('disease_id')"
                                             v-text="form.errors.first('disease_id')"></div>
                                    </el-form-item>
                                </div>

                            </div>
                        </div>
                    </el-form>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
import InlineSvg from 'vue-inline-svg';
import _ from 'lodash';
import Form from "form-backend-validation";

export default {
    components: {
        InlineSvg,

    },
    props: {
        examination_data: {
            type: Object,
            default: () => ({})
        },
        show_diagnose: {default: null},
        show_status: {default:false}
    },
    data() {
        return {
            form: new Form(),
            list_disease: [],
            loading: false

        };
    },
    methods: {

        searchDisease: _.debounce(function (query) {
            this.loading = true;
            const properties = {
                page: 1,
                per_page: 20,
                search: query
            };

            window.axios.get(route('api.disease.index', properties))
                .then((response) => {
                    this.loading = false;
                    this.list_disease = response.data.data;

                });
        }, 300),

    },
    mounted() {

    },
    computed: {
        modelForm: function() {
            return this.examination_data
        }
    },
}
</script>

