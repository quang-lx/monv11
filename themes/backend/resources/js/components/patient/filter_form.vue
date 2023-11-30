<template>
    <div>

        <el-dialog
            width="40%"
            :show-close="false"
            :title="$t('patient.label.filter title')"
            :destroy-on-close="true"
            :visible.sync="show_filter">


            <el-form ref="filterForm"
                     :model="search_data"
                     label-position="top"
                     v-loading.body="loadingFilterPatient"
            >
                <div class="row">
                    <div class="col-sm-6">
                        <el-form-item :label="$t('patient.label.status')" >
                            <el-select v-model="search_data.status" size="small"
                                       :placeholder="$t('patient.label.status')"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listStatus"
                                    :key="'sex'+ item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('patient.label.sex')" >
                            <el-select v-model="search_data.sex" size="small"
                                       :placeholder="$t('patient.label.sex')"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listSex"
                                    :key="'sex'+ item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('patient.label.birthday')" style="width: 100% !important;">
                            <el-date-picker
                                style="width: 100% !important;"
                                size="small"
                                v-model="search_data.time_range"
                                type="daterange"
                                value-format="yyyy-MM-dd"
                                range-separator="-"
                                :start-placeholder="$t('user.label.from date')"
                                :end-placeholder="$t('user.label.to date')">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('patient.label.label data_sources')" >
                            <el-select v-model="search_data.created_by" size="small"
                                       :placeholder="$t('patient.label.label data_sources')"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listDataSource"
                                    :key="'data_source'+ item.id"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                </div>


            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small"  @click="setDefault">{{$t('common.default')}}</el-button>
                <el-button size="small"  @click="closePopup">{{$t('common.cancel')}}</el-button>
                <el-button size="small" type="primary" @click="onSearchPatient">{{$t('common.apply')}}</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>


    export default {
        props: {
            show_filter : {default: false}
        },
        data() {
            return {
                show_popup: this.show_filter,
                search_data: {
                  status: '',
                  created_by: '',
                  sex: '',
                  time_range: []
                },
                loadingFilterPatient: false,
                listStatus: [
                    {
                        value: 1,
                        label: 'Tiếp đón'
                    },
                    {
                        value: 2,
                        label: 'Đang khám'
                    },
                    {
                        value: 3,
                        label: 'Hoàn thành'
                    }
                ],
                listSex: [

                    {
                        value: 1,
                        label: 'Nam'
                    },
                    {
                        value: 2,
                        label: 'Nữ'
                    }
                ],
                listDataSource: [
                    {
                        value: 1,
                        label: 'Local'
                    },
                    {
                        value: 2,
                        label: 'Lis'
                    }
                ],

            };
        },
        methods: {
            onSearchPatient() {
                this.$emit("on-filter", this.search_data) ;
            },


            setDefault() {
                this.search_data = {
                    status: '',
                    created_by: '',
                    sex: '',
                    time_range: []
                }
            }

        },
        watch: {

        },


    }
</script>

<style scoped>

</style>
