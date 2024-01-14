<template>
    <div>


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
                            <div v-for="(item, index) in list_index">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <el-form-item label="Chọn ngày">

                                                    <el-date-picker
                                                        v-model="item.create_date"
                                                        :disabled="!item.is_edit"
                                                        type="date"
                                                        style="width: 100%"
                                                        size="small"
                                                        type="datetime"
                                                        format="HH:mm dd/MM/yyyy"
                                                        value-format="yyyy-MM-dd HH:mm:ss"
                                                        placeholder="Chọn ngày">
                                                    </el-date-picker>

                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3">
                                                <el-form-item label="Chiều cao (cm)">
                                                    <el-input-number :controls="false" v-model="item.height"
                                                                     size="small"
                                                                     style="width: 100%"
                                                                     :disabled="!item.is_edit"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>

                                            </div>
                                            <div class="col-md-3">
                                                <el-form-item label="Cân nặng (kg)">
                                                    <el-input-number :controls="false" v-model="item.weight"
                                                                     size="small"
                                                                     style="width: 100%"
                                                                     :disabled="!item.is_edit"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3">

                                                <el-form-item label="BMI">
                                                    <el-input-number :controls="false" v-model="item.bmi" size="small"
                                                                     style="width: 100%"
                                                                     :disabled="!item.is_edit"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-3">
                                                <el-form-item label="Huyết áp (mmHg) ">
                                                    <el-input-number :controls="false" v-model="item.blood_pressure"
                                                                     :disabled="!item.is_edit"
                                                                     size="small"

                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3">

                                                <el-form-item label="Nhịp tim (bpm)">
                                                    <el-input-number :controls="false" v-model="item.heart_beat"
                                                                     size="small"
                                                                     :disabled="!item.is_edit"
                                                                     style="width: 100%"
                                                                     autocomplete="off"></el-input-number>
                                                </el-form-item>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <el-form-item label="Nhập thông tin sức khoẻ (nếu có)">
                                            <el-input type="textarea" v-model="item.note"
                                                      :autosize="{ minRows: 5, maxRows: 10}"
                                                      :disabled="!item.is_edit"></el-input>

                                        </el-form-item>
                                    </div>
                                    <div class="col-md-1 d-flex justify-content-end align-items-center">


                                                    <i @click="deleteRow(index)"
                                                       style="cursor:pointer; padding-left: 8px">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23"
                                                             viewBox="0 0 20 23" fill="none">
                                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M2.96578 4.53367C4.97033 4.33122 6.97512 4.22998 8.98005 4.22998C12.3454 4.22998 15.7201 4.40127 19.074 4.73364C19.4862 4.77448 19.7872 5.14175 19.7464 5.55394C19.7055 5.96614 19.3383 6.26717 18.9261 6.22632C15.62 5.89869 12.2947 5.72998 8.98005 5.72998C7.02535 5.72998 5.07051 5.8287 3.11543 6.02618L3.11323 6.0264L1.07323 6.2264C0.660996 6.26682 0.294048 5.9654 0.253633 5.55316C0.213218 5.14092 0.514639 4.77397 0.926876 4.73356L2.96578 4.53367Z"
                                                                fill="#2F3748"/>
                                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.4597 3.28456L7.23976 4.59421C7.17116 5.00271 6.7844 5.27824 6.3759 5.20964C5.96741 5.14104 5.69187 4.75428 5.76048 4.34578L5.98048 3.03579C5.98432 3.01297 5.98828 2.98908 5.99228 2.96487C6.06114 2.54899 6.16216 1.93887 6.56885 1.47769C7.04291 0.940117 7.76621 0.75 8.69012 0.75H11.3101C12.2453 0.75 12.9678 0.955399 13.4391 1.49845C13.8463 1.96776 13.9448 2.58006 14.0106 2.98891C14.0138 3.0088 14.0169 3.02822 14.02 3.04711L14.2396 4.34486C14.3087 4.75326 14.0337 5.14037 13.6253 5.20949C13.2169 5.2786 12.8297 5.00355 12.7606 4.59514L12.5399 3.29069C12.4562 2.77767 12.4033 2.59352 12.3062 2.48155C12.2524 2.4196 12.065 2.25 11.3101 2.25H8.69012C7.92402 2.25 7.74232 2.41488 7.69389 2.46981C7.60177 2.57427 7.54978 2.74976 7.4597 3.28456Z"
                                                                fill="#2F3748"/>
                                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M16.8968 7.8916C17.3101 7.91828 17.6236 8.275 17.5969 8.68835L16.9466 18.7625L16.9453 18.7815C16.919 19.1577 16.89 19.5714 16.8125 19.9564C16.7321 20.3556 16.5904 20.7768 16.3033 21.1506C15.7021 21.9333 14.679 22.25 13.2085 22.25H6.78846C5.3179 22.25 4.29484 21.9333 3.69367 21.1506C3.40656 20.7768 3.26487 20.3556 3.18448 19.9564C3.10695 19.5714 3.07798 19.1577 3.05163 18.7815L3.05001 18.7584L2.40002 8.68835C2.37334 8.275 2.6868 7.91828 3.10015 7.8916C3.51351 7.86492 3.87023 8.17838 3.89691 8.59173L4.54663 18.6576C4.54668 18.6583 4.54673 18.659 4.54677 18.6597C4.575 19.0624 4.59888 19.3818 4.65495 19.6602C4.70956 19.9314 4.78537 20.1095 4.88326 20.2369C5.05209 20.4567 5.46903 20.75 6.78846 20.75H13.2085C14.5279 20.75 14.9448 20.4567 15.1137 20.2369C15.2116 20.1095 15.2874 19.9314 15.342 19.6602C15.398 19.3818 15.4219 19.0624 15.4502 18.6597C15.4502 18.659 15.4503 18.6583 15.4503 18.6576L16.1 8.59173C16.1267 8.17838 16.4834 7.86492 16.8968 7.8916Z"
                                                                fill="#2F3748"/>
                                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M7.57812 16C7.57812 15.5858 7.91391 15.25 8.32812 15.25H11.6581C12.0723 15.25 12.4081 15.5858 12.4081 16C12.4081 16.4142 12.0723 16.75 11.6581 16.75H8.32812C7.91391 16.75 7.57812 16.4142 7.57812 16Z"
                                                                fill="#2F3748"/>
                                                          <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M6.75 12C6.75 11.5858 7.08579 11.25 7.5 11.25H12.5C12.9142 11.25 13.25 11.5858 13.25 12C13.25 12.4142 12.9142 12.75 12.5 12.75H7.5C7.08579 12.75 6.75 12.4142 6.75 12Z"
                                                                fill="#2F3748"/>
                                                        </svg>

                                                    </i>




                                    </div>

                                </div>
                                <hr>
                            </div>

                        </div>
                    </el-form>
                </div>

    </div>
</template>

<script>
    import InlineSvg from 'vue-inline-svg';
    import Form from "form-backend-validation";
    import _ from "lodash";

    export default {
        components: {
            InlineSvg,

        },
        props: {

        },
        data() {
            return {
                modelForm: {},
                form: new Form(),
                list_index: [],
                old_data: [],

            };
        },
        methods: {

            addItem() {
                this.list_index.push({
                    create_date: '',
                    height: undefined,
                    weight: undefined,
                    bmi: undefined,
                    blood_pressure: undefined,
                    heart_beat: undefined,
                    is_edit: true,
                    note: null
                })
                this.old_data.push({
                    create_date: '',
                    height: undefined,
                    weight: undefined,
                    bmi: undefined,
                    blood_pressure: undefined,
                    heart_beat: undefined,
                    is_edit: false,
                    note: null
                })
            },
            editRow(index) {
                this.old_data[index] = _.cloneDeep(this.list_index[index])
                this.list_index[index].is_edit = true
            },

            deleteRow(index) {

                this.$confirm("Các thông tin này sẽ bị xóa và không thể hoàn tác.", "XÓA CHỈ SỐ SỨC KHOẺ?", {
                    confirmButtonText: this.confirmBtn ? this.confirmBtn : this.$t('mon.button.deleteBtn'),
                    cancelButtonText: this.cancelBtn ? this.cancelBtn : this.$t('mon.button.cancelBtn'),
                    type: 'warning',
                    confirmButtonClass: 'el-button--danger',
                }).then(() => {
                    if (!this.list_index[index].id) {
                        this.list_index.splice(index, 1);
                    }

                }).catch(() => {

                });
            },

            discardRow(index) {
                if (this.old_data[index]) {
                    this.list_index.splice(index, 1, this.old_data[index])
                } else {
                    this.list_index.splice(index, 1);
                }

            },


        },
        mounted() {

        },
        watch: {
            list_index: {
                handler: function (val, oldVal) {
                    this.$emit("change-value", this.list_index);
                },
                deep: true
            }
        },

    }
</script>

