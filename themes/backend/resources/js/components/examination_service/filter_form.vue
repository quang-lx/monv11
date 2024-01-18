<template>
    <div>

        <el-dialog

            width="40%"
            :show-close="true"
            title="Lọc danh sách khám bệnh "
            :destroy-on-close="true"
            :close-on-click-modal="false"
            @close="closePopup"
            :visible.sync="show_filter">


            <el-form ref="filterForm"
                     :model="search_data"
                     label-position="top"
                     v-loading.body="loadingFilterPatient"
            >
                <div class="row">
                    <div class="col-sm-6">
                        <el-form-item :label="$t('patient.label.birthday')" style="width: 100% !important;">
                            <el-date-picker
                                style="width: 100% !important;"
                                size="small"
                                v-model="search_data.birthday"
                                type="daterange"
                                value-format="yyyy-MM-dd"
                                range-separator="-"
                                :start-placeholder="$t('user.label.from date')"
                                :end-placeholder="$t('user.label.to date')">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('patient.label.sex')" >
                            <el-select v-model="search_data.sex" size="small"
                                       placeholder="Chọn giới tính"
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
                        <el-form-item label="Loại dịch vụ" style="width: 100% !important;">
                            <el-select v-model="search_data.service_type" size="small"
                                       placeholder="Chọn loại dịch vụ"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listServiceType"
                                    :key="'sex'+ item.id"
                                    :label="item.name"
                                    :value="item.id">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item label="Trạng thái" >
                            <el-select v-model="search_data.status" size="small"
                                       placeholder="Chọn trạng thái"
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
                        <el-form-item :label="$t('patient.label.created_at')" style="width: 100% !important;">
                            <el-date-picker
                                style="width: 100% !important;"
                                size="small"
                                v-model="search_data.created_at"
                                type="daterange"
                                value-format="yyyy-MM-dd"
                                range-separator="-"
                                :start-placeholder="$t('user.label.from date')"
                                :end-placeholder="$t('user.label.to date')">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item label="Thời gian trả kết quả" style="width: 100% !important;">
                            <el-date-picker
                                style="width: 100% !important;"
                                size="small"
                                v-model="search_data.result_at"
                                type="daterange"
                                value-format="yyyy-MM-dd"
                                range-separator="-"
                                :start-placeholder="$t('user.label.from date')"
                                :end-placeholder="$t('user.label.to date')">
                            </el-date-picker>
                        </el-form-item>
                    </div>

                    <div class="col-sm-6">
                        <el-form-item label="Người chỉ định" >
                            <el-select v-model="search_data.created_by" size="small"
                                       placeholder="Chọn người chỉ định"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listUser"
                                    :key="'sex'+ item.id"
                                    :label="item.name_display"
                                    :value="item.id">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item label="Người trả kết quả" >
                            <el-select v-model="search_data.result_by" size="small"
                                       placeholder="Chọn người trả kết quả"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listUser"
                                    :key="'sex'+ item.id"
                                    :label="item.name_display"
                                    :value="item.id">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>

                    <div class="col-sm-6">
                        <el-form-item label="Nguồn dữ liệu" >
                            <el-select v-model="search_data.from_source" size="small"
                                       placeholder="Chọn nguồn dữ liệu"
                                       filterable style="width: 100% !important">
                                <el-option
                                    v-for="item in listSource"
                                    :key="'sex'+ item.value"
                                    :label="item.label"
                                    :value="item.value">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>

                    <div class="col-sm-12">
                        <el-form-item label="Dịch vụ" >
                            <div style="max-height: 60vh !important; overflow: scroll">
                                <el-tree
                                    :data="tree_data"
                                    show-checkbox
                                    node-key="id"
                                    ref="tree_service"
                                    @check-change="changeService"

                                    :props="defaultProps">
                                </el-tree>
                            </div>
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
                  sex: '',
                  created_at: [],
                    birthday: [],
                    result_at: [],
                    created_by: null,
                    result_by: null,
                    service_type: null,
                    from_source: null,
                    service_id: []
                },
                loadingFilterPatient: false,
                listServiceType: [],
                listService: [],
                listUser: [],
                listStatus: [
                    {
                        value: 1,
                        label: 'Mới'
                    },
                    {
                        value: 2,
                        label: 'Đang thực hiện'
                    },
                    {
                        value: 3,
                        label: 'Đã có kết quả'
                    },
                    {
                        value: 4,
                        label: 'Đã huỷ'
                    }
                ],
                listSource: [
                    {
                        value: 1,
                        label: 'Local'
                    },
                    {
                        value: 2,
                        label: 'Lis'
                    }
                ],
                listSex: [

                    {
                        value: 1,
                        label: 'Nam'
                    },
                    {
                        value: 0,
                        label: 'Nữ'
                    }
                ],
                tree_data: [],
                defaultProps: {
                    children: 'children',
                    label: 'label'
                },

            };
        },
        methods: {
            changeService(data, checked, indeterminate) {
                this.search_data.service_id = this.$refs.tree_service.getCheckedKeys(true)
            },
            getServiceOptions() {
                const properties = {
                    page: 1,
                    per_page: 9000,
                    q: this.searchQuery
                };

                window.axios.get(route('api.service.tree', properties))
                    .then((response) => {

                        this.tree_data = response.data
                    });
            },

            onSearchPatient() {
                this.$emit("on-filter", this.search_data) ;
            },

            setDefault() {
                this.search_data = {
                    status: '',
                    sex: '',
                    created_at: [],
                    birthday: [],
                    result_at: [],
                    created_by: null,
                    result_by: null,
                    service_type: null,
                    from_source: null,

                }
            },
            getServiceType() {

                const properties = {
                    page: 1,
                    per_page: 10000

                };

                window.axios.get(route('api.servicetype.index', properties))
                    .then((response) => {

                        this.listServiceType = response.data.data;

                    });
            },
            getService() {

                const properties = {
                    page: 1,
                    per_page: 10000

                };

                window.axios.get(route('api.service.index', properties))
                    .then((response) => {

                        this.listService = response.data.data;

                    });
            },
            getUser() {

                const properties = {
                    page: 1,
                    per_page: 10000

                };

                window.axios.get(route('api.users.index', properties))
                    .then((response) => {

                        this.listUser = response.data.data;

                    });
            },
        },
        mounted() {
            this.getServiceOptions();
            this.getServiceType();
            this.getService();
            this.getUser();

        },

    }
</script>

<style scoped>

</style>
