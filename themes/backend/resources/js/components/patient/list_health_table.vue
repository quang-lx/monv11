<template>
    <div>


                <div class="card">

                    <el-form :model="modelForm" label-position="top">
                        <div class="card-body">
                            <div class="row justify-content-between mb-2">
                                <div class="col-md-6">
                                    <div class="row d-flex flex-row align-items-center">

                                    </div>

                                </div>
                                <div class="col-md-6 d-flex flex-row align-items-center d-flex justify-content-end">

                                    <div class="d-flex flex-row">
                                        <span class=" mr-3">Thời gian</span>
                                        <el-date-picker size="small" v-model="filter_date_range" type="daterange" range-separator="-"
                                                        start-placeholder="Từ ngày" end-placeholder="Đến ngày" format="dd/MM/yyyy"
                                                        value-format="yyyy-MM-dd" @change="fetchData({})">
                                        </el-date-picker>
                                    </div>

                                </div>

                            </div>

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
                                                        format="dd/MM/yyyy"
                                                        value-format="yyyy-MM-dd"
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
                                        <span v-if="item.is_edit">
                                                <i @click="saveRow(index)" style="cursor:pointer">
                                                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                                          viewBox="0 0 24 25" fill="none">
                                                          <g clip-path="url(#clip0_1458_161437)">
                                                            <path
                                                                d="M7 22.5H9V24.5H7V22.5ZM11 22.5H13V24.5H11V22.5ZM15 22.5H17V24.5H15V22.5ZM17 2.5H5C4.46957 2.5 3.96086 2.71071 3.58579 3.08579C3.21071 3.46086 3 3.96957 3 4.5V18.5C3 19.0304 3.21071 19.5391 3.58579 19.9142C3.96086 20.2893 4.46957 20.5 5 20.5H19C20.1 20.5 21 19.6 21 18.5V6.5L17 2.5ZM19 18.5H5V4.5H16.17L19 7.33V18.5ZM12 11.5C10.34 11.5 9 12.84 9 14.5C9 16.16 10.34 17.5 12 17.5C13.66 17.5 15 16.16 15 14.5C15 12.84 13.66 11.5 12 11.5ZM6 5.5H15V9.5H6V5.5Z"
                                                                fill="#6C757D"/>
                                                          </g>
                                                          <defs>
                                                            <clipPath id="clip0_1458_161437">
                                                              <rect width="24" height="24" fill="white" transform="translate(0 0.5)"/>
                                                            </clipPath>
                                                          </defs>
                                                        </svg>
                                                </i>
                                            <i @click="discardRow(index)" style="cursor:pointer">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25"
                                                             viewBox="0 0 24 25" fill="none">
                                                          <path
                                                              d="M18.2983 6.21022C18.2058 6.11752 18.0959 6.04397 17.9749 5.99379C17.8539 5.94361 17.7242 5.91778 17.5933 5.91778C17.4623 5.91778 17.3326 5.94361 17.2116 5.99379C17.0907 6.04397 16.9808 6.11752 16.8883 6.21022L11.9983 11.0902L7.10827 6.20022C7.01569 6.10764 6.90578 6.0342 6.78481 5.9841C6.66385 5.93399 6.5342 5.9082 6.40327 5.9082C6.27234 5.9082 6.14269 5.93399 6.02173 5.9841C5.90076 6.0342 5.79085 6.10764 5.69827 6.20022C5.60569 6.29281 5.53225 6.40272 5.48214 6.52368C5.43204 6.64464 5.40625 6.77429 5.40625 6.90522C5.40625 7.03615 5.43204 7.1658 5.48214 7.28677C5.53225 7.40773 5.60569 7.51764 5.69827 7.61022L10.5883 12.5002L5.69827 17.3902C5.60569 17.4828 5.53225 17.5927 5.48214 17.7137C5.43204 17.8346 5.40625 17.9643 5.40625 18.0952C5.40625 18.2262 5.43204 18.3558 5.48214 18.4768C5.53225 18.5977 5.60569 18.7076 5.69827 18.8002C5.79085 18.8928 5.90076 18.9662 6.02173 19.0163C6.14269 19.0665 6.27234 19.0922 6.40327 19.0922C6.5342 19.0922 6.66385 19.0665 6.78481 19.0163C6.90578 18.9662 7.01569 18.8928 7.10827 18.8002L11.9983 13.9102L16.8883 18.8002C16.9809 18.8928 17.0908 18.9662 17.2117 19.0163C17.3327 19.0665 17.4623 19.0922 17.5933 19.0922C17.7242 19.0922 17.8538 19.0665 17.9748 19.0163C18.0958 18.9662 18.2057 18.8928 18.2983 18.8002C18.3909 18.7076 18.4643 18.5977 18.5144 18.4768C18.5645 18.3558 18.5903 18.2262 18.5903 18.0952C18.5903 17.9643 18.5645 17.8346 18.5144 17.7137C18.4643 17.5927 18.3909 17.4828 18.2983 17.3902L13.4083 12.5002L18.2983 7.61022C18.6783 7.23022 18.6783 6.59022 18.2983 6.21022Z"
                                                              fill="#FF0707"/>
                                                        </svg>
                                            </i>
                                        </span>
                                        <span v-else>
                                            <i @click="editRow(index)" style="cursor:pointer">

                                              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23"
                                                   viewBox="0 0 20 23" fill="none">
                                                  <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M13.5205 0.937258C14.6873 0.788062 15.8677 1.26518 17.0671 2.39373L17.0685 2.39503C18.2719 3.53312 18.8198 4.68762 18.7376 5.8635C18.6581 6.99975 17.9994 7.96146 17.2483 8.75501M17.2483 8.75501L9.04239 17.4407C8.81106 17.6926 8.49957 17.906 8.20427 18.0639C7.90518 18.2238 7.55921 18.3606 7.23442 18.4184L7.22943 18.4193L4.01058 18.969C3.23001 19.1036 2.48151 18.9086 1.94831 18.4029C1.41586 17.898 1.18057 17.1616 1.26773 16.3771L1.26799 16.3749L1.63959 13.1208C1.68275 12.7971 1.80297 12.4468 1.94468 12.143C2.08588 11.8402 2.27853 11.5191 2.50651 11.2764L2.50797 11.2749L10.718 2.58489C11.4695 1.79102 12.3931 1.08143 13.5205 0.937258M11.8078 3.61556C11.8077 3.61569 11.8079 3.61542 11.8078 3.61556L3.59978 12.3035C3.59961 12.3036 3.59995 12.3033 3.59978 12.3035C3.51781 12.3909 3.40521 12.5602 3.30412 12.7769C3.20486 12.9898 3.14524 13.1867 3.12737 13.3133L2.75856 16.5428C2.75852 16.5431 2.75848 16.5435 2.75845 16.5438C2.71594 16.9287 2.83557 17.1771 2.98048 17.3145C3.12478 17.4513 3.37628 17.5563 3.75572 17.4909L3.75687 17.4907L6.97398 16.9412C7.09925 16.9185 7.29227 16.8505 7.49703 16.741C7.70461 16.6301 7.86076 16.5104 7.93893 16.4246L7.94789 16.4148L16.158 7.72489C16.8266 7.01855 17.1982 6.37489 17.2412 5.7589C17.2815 5.18244 17.0445 4.43718 16.0386 3.48564C15.0383 2.54465 14.2839 2.35185 13.7108 2.42514C13.0984 2.50345 12.4761 2.90968 11.8078 3.61556Z"
                                                        fill="#2F3748"/>
                                                  <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M9.77528 3.80885C10.1846 3.74509 10.568 4.02518 10.6318 4.43446C11.0089 6.85508 12.9734 8.70768 15.4159 8.95369C15.828 8.9952 16.1285 9.36294 16.087 9.77507C16.0454 10.1872 15.6777 10.4876 15.2656 10.4461C12.148 10.1321 9.63255 7.76475 9.14967 4.66537C9.08591 4.25609 9.366 3.87262 9.77528 3.80885Z"
                                                        fill="#2F3748"/>
                                                  <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M0.25 21.5C0.25 21.0858 0.585786 20.75 1 20.75H19C19.4142 20.75 19.75 21.0858 19.75 21.5C19.75 21.9142 19.4142 22.25 19 22.25H1C0.585786 22.25 0.25 21.9142 0.25 21.5Z"
                                                        fill="#2F3748"/>
                                                </svg>
                                            </i>
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


                                            </span>


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
            examination_id: {default: null},
            patient_id: {default: null},
        },
        data() {
            return {
                modelForm: {},
                form: new Form(),
                list_index: [],
                old_data: [],
                filter_date_range: null,

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
                    } else {
                        const vm = this;
                        let routeUri = route('api.examinationhealth.destroy', {examinationhealth: this.list_index[index].id});
                        window.axios.delete(routeUri)
                            .then((response) => {
                                if (response.data.errors === false) {

                                    vm.$notify({
                                        type: 'success',
                                        title: 'Thành công',
                                        message: response.data.message,
                                    });
                                    this.list_index.splice(index, 1);

                                }
                            })
                            .catch((error) => {

                                this.$notify({
                                    type: 'error',
                                    title: 'Thất bại',
                                    message: error.data.message,
                                });
                            });
                    }

                }).catch(() => {

                });
            },
            saveRow(index) {
                let routeUri = route('api.examinationhealth.store');
                const vm = this;
                if (this.list_index[index].id) {
                    routeUri = route('api.examinationhealth.update', {examinationhealth: this.list_index[index].id});
                }
                const params = _.merge(this.list_index[index], {
                    patient_id: this.patient_id,
                    examination_id: this.examination_id
                })
                window.axios.post(routeUri, params)
                    .then((response) => {
                        if (response.data.errors === false) {
                            vm.$notify({
                                type: 'success',
                                title: 'Thành công',
                                message: response.data.message,
                            });
                            this.list_index[index].id = response.data.id
                            this.list_index[index].is_edit = 0
                        }
                    })
                    .catch((error) => {

                        vm.$notify({
                            type: 'error',
                            title: 'Thất bại',
                            message: error.data.message,
                        });
                    });
            },
            discardRow(index) {
                if (this.old_data[index]) {
                    this.list_index.splice(index, 1, this.old_data[index])
                } else {
                    this.list_index.splice(index, 1);
                }

            },

            fetchData() {
                const properties = {
                    page: this.meta.current_page,
                    per_page: this.meta.per_page,
                    order_by: this.order_meta.order_by,
                    order: this.order_meta.order,
                    examination_id: this.examination_id,
                    patient_id: this.patient_id,
                    filter_date_range: this.filter_date_range,

                };

                window.axios.get(route('api.examinationhealth.index', _.merge(properties, {})))
                    .then((response) => {
                        this.tableIsLoading = false;
                        this.tableIsLoading = false;
                        this.list_index = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;
                        this.order_meta.order_by = properties.order_by;
                        this.order_meta.order = properties.order;
                        this.show_filter = false;
                    });
            },

        },
        mounted() {
            this.fetchData();
        },

    }
</script>

