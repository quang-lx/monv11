<template>
    <div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <el-form :model="modelForm" label-position="top">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
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
                                        <span class="f-text-title pl-1"> Chỉ số sức khoẻ</span>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex flex-row align-items-center d-flex justify-content-end">
                                    <span class="f-action pl-4 f-pointer" @click="addItem">
                                        <inline-svg src="/images/add.svg"/>  {{ $t('common.add') }}

                                    </span>
                                </div>
                            </div>
                            <div v-for="item in list_index">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <el-form-item label="Chọn ngày">

                                                    <el-date-picker
                                                        v-model="item.date"
                                                        type="date"
                                                        style="width: 100%"
                                                        size="small"
                                                        format="dd/MM/yyyy"
                                                        value-format="yyyy-MM-dd"
                                                        placeholder="Chọn ngày">
                                                    </el-date-picker>

                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3">
                                                <el-form-item label="Nhập chiều cao (cm)">
                                                    <el-input-number :controls="false" v-model="item.height"
                                                                     size="small"
                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>

                                            </div>
                                            <div class="col-md-3">
                                                <el-form-item label="Nhập cân nặng (kg)">
                                                    <el-input-number :controls="false" v-model="item.weight"
                                                                     size="small"
                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3">

                                                <el-form-item label="BMI">
                                                    <el-input-number :controls="false" v-model="item.bmi" size="small"
                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">
                                                <el-form-item label="Huyết áp (mmHg) ">
                                                    <el-input-number :controls="false" v-model="item.blood_pressure"
                                                                     size="small"

                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3">

                                                <el-form-item label="Nhịp tim (bpm)">
                                                    <el-input-number :controls="false" v-model="item.heart_beat"
                                                                     size="small"
                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <el-form-item label="Nhập thông tin sức khoẻ (nếu có)">
                                            <el-input type="textarea" v-model="item.note"></el-input>

                                        </el-form-item>
                                    </div>

                                </div>
                                <hr>
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
        props: {},
        data() {
            return {
                form: new Form(),
                list_index: [
                    {
                        date: '',
                        height: null,
                        weight: null,
                        bmi: null,
                        blood_pressure: null,
                        heart_beat: null,
                        note: null
                    }
                ]

            };
        },
        methods: {

            addItem() {
                this.list_index.push({
                    date: '',
                    height: null,
                    weight: null,
                    bmi: null,
                    blood_pressure: null,
                    heart_beat: null,
                    note: null
                })
            }

        },
        mounted() {

        },
        computed: {
            modelForm: function () {
                return this.examination_data
            }
        },
    }
</script>

