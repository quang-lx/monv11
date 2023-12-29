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
                                    <div  v-if="examination_service.status == 3" @click="show_result_popup = true" class="ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="18" viewBox="0 0 20 18" fill="none">
                                            <path d="M16.875 7.30441H15.9821C15.8839 7.30441 15.8036 7.38477 15.8036 7.48298V8.37584C15.8036 8.47405 15.8839 8.55441 15.9821 8.55441H16.875C16.9732 8.55441 17.0536 8.47405 17.0536 8.37584V7.48298C17.0536 7.38477 16.9732 7.30441 16.875 7.30441ZM17.5893 4.98298H14.9107V0.250837C14.9107 0.152623 14.8304 0.0722656 14.7321 0.0722656H5.26786C5.16964 0.0722656 5.08929 0.152623 5.08929 0.250837V4.98298H2.41071C1.42411 4.98298 0.625 5.78209 0.625 6.76869V14.0901C0.625 14.4852 0.944196 14.8044 1.33929 14.8044H5.08929V17.7508C5.08929 17.8491 5.16964 17.9294 5.26786 17.9294H14.7321C14.8304 17.9294 14.9107 17.8491 14.9107 17.7508V14.8044H18.6607C19.0558 14.8044 19.375 14.4852 19.375 14.0901V6.76869C19.375 5.78209 18.5759 4.98298 17.5893 4.98298ZM6.60714 1.59012H13.3929V4.98298H6.60714V1.59012ZM13.3929 16.4116H6.60714V10.2508H13.3929V16.4116ZM17.8571 13.2866H14.9107V8.73298H5.08929V13.2866H2.14286V6.76869C2.14286 6.62137 2.26339 6.50084 2.41071 6.50084H17.5893C17.7366 6.50084 17.8571 6.62137 17.8571 6.76869V13.2866Z" fill="black"/>
                                        </svg>
                                        <span> In kết quả</span>
                                    </div>

                                    <div class="ml-2">
                                        <i @click="onCancelService(examination_service.id)" role="button" class=" mr-2" v-if="examination_service.status == 2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                                <path d="M19.267 5.71022C19.1745 5.61752 19.0646 5.54397 18.9436 5.49379C18.8227 5.44361 18.693 5.41778 18.562 5.41778C18.4311 5.41778 18.3014 5.44361 18.1804 5.49379C18.0594 5.54397 17.9495 5.61752 17.857 5.71022L12.967 10.5902L8.07702 5.70022C7.98444 5.60764 7.87453 5.5342 7.75356 5.4841C7.6326 5.43399 7.50295 5.4082 7.37202 5.4082C7.24109 5.4082 7.11144 5.43399 6.99048 5.4841C6.86951 5.5342 6.7596 5.60764 6.66702 5.70022C6.57444 5.79281 6.501 5.90272 6.45089 6.02368C6.40079 6.14464 6.375 6.27429 6.375 6.40522C6.375 6.53615 6.40079 6.6658 6.45089 6.78677C6.501 6.90773 6.57444 7.01764 6.66702 7.11022L11.557 12.0002L6.66702 16.8902C6.57444 16.9828 6.501 17.0927 6.45089 17.2137C6.40079 17.3346 6.375 17.4643 6.375 17.5952C6.375 17.7262 6.40079 17.8558 6.45089 17.9768C6.501 18.0977 6.57444 18.2076 6.66702 18.3002C6.7596 18.3928 6.86951 18.4662 6.99048 18.5163C7.11144 18.5665 7.24109 18.5922 7.37202 18.5922C7.50295 18.5922 7.6326 18.5665 7.75356 18.5163C7.87453 18.4662 7.98444 18.3928 8.07702 18.3002L12.967 13.4102L17.857 18.3002C17.9496 18.3928 18.0595 18.4662 18.1805 18.5163C18.3014 18.5665 18.4311 18.5922 18.562 18.5922C18.693 18.5922 18.8226 18.5665 18.9436 18.5163C19.0645 18.4662 19.1744 18.3928 19.267 18.3002C19.3596 18.2076 19.433 18.0977 19.4831 17.9768C19.5333 17.8558 19.559 17.7262 19.559 17.5952C19.559 17.4643 19.5333 17.3346 19.4831 17.2137C19.433 17.0927 19.3596 16.9828 19.267 16.8902L14.377 12.0002L19.267 7.11022C19.647 6.73022 19.647 6.09022 19.267 5.71022Z" fill="#FF0707"/>
                                            </svg>
                                            <span style="color: #424242">Huỷ dịch vụ</span>
                                        </i>
                                        <i disabled role="button" class=" mr-2" v-else>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                                <g opacity="0.3">
                                                    <path d="M19.267 5.71022C19.1745 5.61752 19.0646 5.54397 18.9436 5.49379C18.8227 5.44361 18.693 5.41778 18.562 5.41778C18.4311 5.41778 18.3014 5.44361 18.1804 5.49379C18.0594 5.54397 17.9495 5.61752 17.857 5.71022L12.967 10.5902L8.07702 5.70022C7.98444 5.60764 7.87453 5.5342 7.75356 5.4841C7.6326 5.43399 7.50295 5.4082 7.37202 5.4082C7.24109 5.4082 7.11144 5.43399 6.99048 5.4841C6.86951 5.5342 6.7596 5.60764 6.66702 5.70022C6.57444 5.79281 6.501 5.90272 6.45089 6.02368C6.40079 6.14464 6.375 6.27429 6.375 6.40522C6.375 6.53615 6.40079 6.6658 6.45089 6.78677C6.501 6.90773 6.57444 7.01764 6.66702 7.11022L11.557 12.0002L6.66702 16.8902C6.57444 16.9828 6.501 17.0927 6.45089 17.2137C6.40079 17.3346 6.375 17.4643 6.375 17.5952C6.375 17.7262 6.40079 17.8558 6.45089 17.9768C6.501 18.0977 6.57444 18.2076 6.66702 18.3002C6.7596 18.3928 6.86951 18.4662 6.99048 18.5163C7.11144 18.5665 7.24109 18.5922 7.37202 18.5922C7.50295 18.5922 7.6326 18.5665 7.75356 18.5163C7.87453 18.4662 7.98444 18.3928 8.07702 18.3002L12.967 13.4102L17.857 18.3002C17.9496 18.3928 18.0595 18.4662 18.1805 18.5163C18.3014 18.5665 18.4311 18.5922 18.562 18.5922C18.693 18.5922 18.8226 18.5665 18.9436 18.5163C19.0645 18.4662 19.1744 18.3928 19.267 18.3002C19.3596 18.2076 19.433 18.0977 19.4831 17.9768C19.5333 17.8558 19.559 17.7262 19.559 17.5952C19.559 17.4643 19.5333 17.3346 19.4831 17.2137C19.433 17.0927 19.3596 16.9828 19.267 16.8902L14.377 12.0002L19.267 7.11022C19.647 6.73022 19.647 6.09022 19.267 5.71022Z" fill="#FF0707"/>
                                                </g>
                                            </svg>
                                            <span style="color:  #424242; opacity: 0.5;">Huỷ dịch vụ</span>
                                        </i>
                                    </div>
                                </div>

                                <el-form
                                    v-if="examination_service"
                                         :rules="formRules"
                                         ref="modelForm"
                                         :model="examination_service"
                                         label-position="top"
                                         v-loading.body="loading"
                                >

                                    <div class="row">
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.code')"
                                                          prop="code"
                                                          :class="{'el-form-item is-error': form.errors.has('code') }">
                                                <el-input disabled maxlength="255" v-model="examination_service.service.code" size="small"
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
                                                            style="width: 100%" size="small">
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
                                                           disabled    style="width: 100%"
                                                          autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('max_value') }">
                                                <el-input :controls="false" v-model="examination_service.service.max_value" size="small"
                                                          disabled
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
                                                                 style="width: 100%; text-align: left"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.male_max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('male_max_value') }">
                                                <el-input disabled v-model="examination_service.male_max_value" size="small"
                                                                 style="width: 100%; text-align: left"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.female_min_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('female_min_value') }">
                                                <el-input disabled  v-model="examination_service.female_min_value" size="small"
                                                                 style="width: 100%"
                                                                 autocomplete="off"></el-input>

                                            </el-form-item>
                                        </div>
                                        <div class="col-md-3">
                                            <el-form-item :label="$t('service.label.female_max_value')"
                                                          :class="{'el-form-item is-error': form.errors.has('female_max_value') }">
                                                <el-input disabled v-model="examination_service.service.female_max_value" size="small"
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
                                                         class="examination_service_status"
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

        <el-dialog title="In kết quả" :visible.sync="show_result_popup" top="2vh">

            <vue-pdf-embed :source="examination_service.pdf_link"  v-if="examination_service.pdf_link"/>
            <span v-else>Chưa có file kết quả</span>
        </el-dialog>
    </div>


</template>

<script>
    import Form from 'form-backend-validation';
    import _ from "lodash";
    import VuePdfEmbed from 'vue-pdf-embed/dist/vue2-pdf-embed'
    export default {
        props: {
            examination_service: {default: {}},
        },
        components: {
            VuePdfEmbed
        },
        data() {
            return {
                form: new Form(),
                loading: false,
                show_result_popup: false,
                 formRules: {

                }


            };
        },
        methods: {
            onCancelService(id) {
                this.$confirm("Dịch vụ sẽ bị huỷ, bạn có chắc chắn huỷ dịch vụ này?", 'Huỷ dịch vụ', {
                    confirmButtonText: "Huỷ",
                    cancelButtonText:"Không",
                    // type: 'warning',
                    confirmButtonClass: 'el-button--primary',
                }).then(() => {

                    window.axios.post(route('api.examinationservice.cancel',{examinationservice:id}))
                        .then((response) => {
                            if (response.data.errors === false) {
                                this.data[idx].status = response.data.model.status
                                this.data[idx].status_text = response.data.model.status_text
                                this.data[idx].status_color = response.data.model.status_color
                                this.$notify({
                                    type: 'success',
                                    title: "Huỷ thành công",
                                    message: response.data.message,
                                });


                            }
                        })
                        .catch((error) => {

                            this.$notify({
                                type: 'error',
                                title: "Huỷ thất bại",
                                message: error.data.message,
                            });
                        })
                }).catch(() => {

                });
            },


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
