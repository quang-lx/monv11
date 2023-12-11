<template>
    <div>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <el-form  :model="modelForm" label-position="top" >
                                                <div class="card-body">

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
                                                        <span class="f-text-title pl-1"> Thông tin bệnh nhân</span>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.name')" prop="name"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('name') }">
                                                                <el-input  maxlength="255" v-model="modelForm.name" size="small"
                                                                          disabled
                                                                          placeholder="Nhập họ và tên"></el-input>
                                                                <div class="el-form-item__error" v-if="form.errors.has('name')"
                                                                     v-text="form.errors.first('name')"></div>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.sex')" prop="sex"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('sex') }">
                                                                <el-select v-model="modelForm.sex" placeholder="Chọn giới tính" disabled
                                                                           size="small">
                                                                    <el-option v-for="item in sexs" :key="item.value"
                                                                               :label="item.label"
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
                                                                <el-date-picker v-model="modelForm.birthday" type="date" disabled
                                                                                format="dd/MM/yyyy" size="small"
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
                                                                <el-input maxlength="255" v-model="modelForm.phone" size="small" disabled
                                                                          placeholder="Nhập số điện thoại"></el-input>
                                                                <div class="el-form-item__error" v-if="form.errors.has('phone')"
                                                                     v-text="form.errors.first('phone')"></div>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.email')" prop="email"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('email') }">
                                                                <el-input maxlength="255" v-model="modelForm.email" size="small" disabled
                                                                          placeholder="Nhập email"></el-input>
                                                                <div class="el-form-item__error" v-if="form.errors.has('email')"
                                                                     v-text="form.errors.first('email')"></div>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.papers')" prop="papers"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('papers') }">
                                                                <el-input v-model="modelForm.papers" size="small" disabled
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
                                                                <el-input maxlength="255" v-model="modelForm.job" size="small" disabled
                                                                          placeholder="Nhập đơn vị làm việc hoặc nghề nghiệp"></el-input>
                                                                <div class="el-form-item__error" v-if="form.errors.has('job')"
                                                                     v-text="form.errors.first('job')"></div>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.address')" prop="address"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('address') }">
                                                                <el-input v-model="modelForm.address" size="small" disabled
                                                                          placeholder="Nhập địa chỉ"></el-input>
                                                                <div class="el-form-item__error" v-if="form.errors.has('address')"
                                                                     v-text="form.errors.first('address')"></div>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4"  >
                                                            <el-form-item :label="$t('patient.label.label status')" prop="status"
                                                                          :class="[{ 'el-form-item is-error': form.errors.has('status') }, modelForm.status_class]">
                                                                <el-input disabled

                                                                          v-model="modelForm.status_text" size="small"></el-input>
                                                            </el-form-item>
                                                        </div>

                                                    </div>

                                                    <div class="row" >
                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.created_at')" prop="created_at"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('created_at') }">
                                                                <el-input disabled
                                                                          v-model="modelForm.created_at" size="small"></el-input>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.created_by_info')"
                                                                          prop="created_by_info"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('created_by_info') }">
                                                                <el-input disabled
                                                                          v-model="modelForm.created_by_info" size="small"></el-input>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.label data_sources')"
                                                                          prop="data_sources"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('data_sources') }">
                                                                <el-input disabled
                                                                          v-model="modelForm.data_sources" size="small"></el-input>

                                                            </el-form-item>
                                                        </div>

                                                    </div>


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
                                                        <span class="f-text-title pl-1"> Thông tin người nhà</span>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.dependant')" prop="dependant"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('dependant') }">
                                                                <el-input maxlength="255" v-model="modelForm.dependant" size="small" disabled
                                                                          placeholder="Nhập họ và tên"></el-input>
                                                                <div class="el-form-item__error" v-if="form.errors.has('dependant')"
                                                                     v-text="form.errors.first('dependant')"></div>
                                                            </el-form-item>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <el-form-item :label="$t('patient.label.phone_dependant')"
                                                                          prop="phone_dependant"
                                                                          :class="{ 'el-form-item is-error': form.errors.has('phone_dependant') }">
                                                                <el-input  maxlength="255" v-model="modelForm.phone_dependant" size="small"
                                                                          disabled
                                                                          placeholder="Nhập số điện thoại"></el-input>
                                                                <div class="el-form-item__error"
                                                                     v-if="form.errors.has('phone_dependant')"
                                                                     v-text="form.errors.first('phone_dependant')"></div>
                                                            </el-form-item>
                                                        </div>

                                                    </div>



                                                </div><!-- /.card-body -->
                                            </el-form>
                                        </div>
                                    </div>
                                </div>




            </div>
        </section>




    </div>
</template>

<script>
    import Form from 'form-backend-validation';

    export default {
        props: {
            show_diagnose: {default: null},
            modelForm: {default: {}, Object}

        },
        components: {

        },
        data() {
            return {

                form: new Form(),


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

            };
        },
        methods: {



        },
        mounted() {


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
