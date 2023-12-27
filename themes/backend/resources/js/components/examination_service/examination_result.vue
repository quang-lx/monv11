<template>
    <div>

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
                                    <span class="f-text-title pl-1"> Kết quả khám</span>
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
                                                <el-input disabled maxlength="255" v-model="examination_service.service.code" size="small"
                                                placeholder="Nhập mã dịch vụ"
                                                ></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item label="Số phiếu"

                                                          :class="{'el-form-item is-error': form.errors.has('code') }">
                                                <el-input disabled maxlength="255" v-model="examination_service.code" size="small" ></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.name')"
                                                          prop="name"
                                                          :class="{'el-form-item is-error': form.errors.has('name') }">
                                                <el-input
                                                    disabled
                                                    maxlength="255" v-model="examination_service.service.name" size="small"
                                                          placeholder="Nhập tên dịch vụ"
                                                ></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.type')"
                                                          prop="type"
                                                          :class="{'el-form-item is-error': form.errors.has('type') }">
                                                <el-select v-model="examination_service.service.type"
                                                           disabled
                                                           filterable
                                                           placeholder="Chọn loại dịch vụ" style="width: 100%" size="small">
                                                    <el-option v-for="item in list_service_type" :key="item.id" :label="item.name"
                                                               :value="item.id">
                                                    </el-option>
                                                </el-select>

                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('min_value') }">
                                                <el-input  v-model="examination_service.service.min_value" size="small" disabled
                                                                 style="width: 100%"
                                                          placeholder="Nhập Trẻ em thấp"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('max_value') }">
                                                <el-input :controls="false" v-model="examination_service.service.max_value" size="small"
                                                          placeholder="Nhập Trẻ em cao" disabled
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.ref_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('ref_value') }">
                                                <el-input disabled :controls="false" v-model="examination_service.service.ref_value" size="small"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.unit')"
                                                          :class="{'el-form-item is-error': form.errors.has('unit') }">
                                                <el-input disabled  maxlength="255" v-model="examination_service.service.unit" size="small"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.male_min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('male_min_value') }">
                                                <el-input disabled v-model="examination_service.male_min_value" size="small"
                                                          placeholder="Nhập giá nam trị thấp"
                                                                 style="width: 100%; text-align: left"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.male_max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('male_max_value') }">
                                                <el-input disabled v-model="examination_service.male_max_value" size="small"
                                                          placeholder="Nhập giá trị nam cao"
                                                                 style="width: 100%; text-align: left"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.female_min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('female_min_value') }">
                                                <el-input disabled  v-model="examination_service.female_min_value" size="small"
                                                          placeholder="Nhập giá trị nữ thấp"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.female_max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('female_max_value') }">
                                                <el-input disabled v-model="examination_service.service.female_max_value" size="small"
                                                          placeholder="Nhập giá trị nữ cao"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <el-form-item label="Kết quả"  class = "idic_result">
                                                <el-input disabled v-model="examination_service.ket_qua" size="small"
                                                           style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-6">
                                            <el-form-item label="Kết luận"  class = "idic_result">
                                                <el-input disabled v-model="examination_service.ket_luan" size="small"
                                                          style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item label="Thời gian chỉ định">
                                                <el-input disabled v-model="examination_service.created_at" size="small"
                                                          style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item label="Nguồn dữ liệu"
                                                          :class="{'el-form-item is-error': form.errors.has('source_text') }">
                                                <el-input disabled v-model="examination_service.source_text" size="small"
                                                          style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item label="Trạng thái kết quả"
                                                          :class="{'el-form-item is-error': form.errors.has('status_text') }">
                                                <el-input disabled v-model="examination_service.status_text" size="small"
                                                          :style="{ background: examination_service.status_color }"
                                                          style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item label="Thời gian trả kết quả"
                                                          :class="{'el-form-item is-error': form.errors.has('result_at') }">
                                                <el-input disabled v-model="examination_service.result_at" size="small"
                                                          style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item label="Người trả kết quả"
                                                          :class="{'el-form-item is-error': form.errors.has('result_by_info') }">
                                                <el-input disabled v-model="examination_service.result_by_info" size="small"
                                                          style="width: 100%"
                                                          autocomplete="off"></el-input>

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
    import _ from "lodash";

    export default {
        props: {
            examination_service: {default: {}},
        },

        data() {
            return {
                form: new Form(),
                loading: false,
                 formRules: {

                }


            };
        },
        methods: {



        },
        computed: {
            list_service_type: function () {
                return [
                    {
                        id: this.examination_service.service.type,
                        name: this.examination_service.service.type_name,
                    }
                ]
            }
        }

    }
</script>

<style scoped>


</style>
