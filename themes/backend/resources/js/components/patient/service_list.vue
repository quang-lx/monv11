<template>
    <div>





                <div class="card">

                    <div class="card-body">
                        <div class="row justify-content-between mb-2">
                            <div class="col-md-8">
                                <div class="row d-flex flex-row align-items-center">
                                    <span class="col-3">Danh sách dịch vụ</span>
                                    <el-input class="col-5" suffix-icon="el-icon-search" @keyup.native="performSearch"
                                              placeholder="Tìm kiếm dịch vụ" size="small" v-model="searchQuery">
                                    </el-input>
                                    <span class="f-action pl-4 f-pointer" @click="printServiceDesignation" v-if="show_print">
                        <inline-svg src="/images/PrinterOutlined.svg" />
                    </span>
                                </div>

                            </div>
                            <div class="col-md-4 d-flex flex-row align-items-center d-flex justify-content-end">

                <span class="f-action pl-4 f-pointer" @click="() => { show_add_service_form = true, getServiceOptions() }"
                      v-if="show_add_icon">
                    <inline-svg src="/images/add.svg" /> {{ $t('common.add') }}

                </span>




                                <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                                               :current-page.sync="meta.current_page" :page-sizes="[20, 40, 60, 80, 100]"
                                               :page-size="parseInt(meta.per_page)" layout="sizes, prev, pager, next" :total="meta.total"
                                               v-if="meta.total > 25">
                                </el-pagination>

                            </div>

                        </div>

                        
                        <div class="sc-table">

                            <el-table :data="data" stripe style="width: 100%" ref="dataTable"
                                v-loading.body="tableIsLoading" @sort-change="handleSortChange">
                                <el-table-column :label="$t('service.label.stt')" :index="indexMethod" type="index"
                                    width="100" align="center">
                                </el-table-column>
                                <el-table-column prop="code" label="Số phiếu" width="120" align="center">
                                </el-table-column>

                                <el-table-column prop="code" :label="$t('service.label.code')" width="120" align="center">
                                    <template slot-scope="scope">
                                        <span> {{ scope.row.service.code }}</span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="name" :label="$t('service.label.name')" min-width="150"
                                    align="center">
                                    <template slot-scope="scope">
                                        <span> {{ scope.row.service.name }}</span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="status" :label="$t('patient_has_service.label.status')"
                                    align="center" width="150">
                                    <template slot-scope="scope">
                                        <span :style="{ color: scope.row.status_color }"> {{ scope.row.status_text }}</span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="created_at" :label="$t('patient_has_service.label.created_at')"
                                    width="150">
                                </el-table-column>
                                <el-table-column prop="created_by" :label="$t('patient_has_service.label.created_by')"
                                    width="150">
                                    <template slot-scope="scope">
                                        <span> {{ scope.row.created_by_name }}</span>
                                    </template>
                                </el-table-column>

                                <el-table-column prop="actions" :label="$t('common.action')" width="100" fixed="right">
                                    <template slot-scope="scope">
                                        <i @click="detailService(scope.row.id)" style="cursor:pointer; padding-left: 8px">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20"
                                                viewBox="0 0 21 20" fill="none">
                                                <path
                                                    d="M9 14.375H14V15.625H9V14.375ZM6.5 14.375H7.75V15.625H6.5V14.375ZM9 11.25H14V12.5H9V11.25ZM6.5 11.25H7.75V12.5H6.5V11.25ZM9 8.125H14V9.375H9V8.125ZM6.5 8.125H7.75V9.375H6.5V8.125Z"
                                                    fill="black" />
                                                <path
                                                    d="M15.875 3.125H14V2.5C14 2.16848 13.8683 1.85054 13.6339 1.61612C13.3995 1.3817 13.0815 1.25 12.75 1.25H7.75C7.41848 1.25 7.10054 1.3817 6.86612 1.61612C6.6317 1.85054 6.5 2.16848 6.5 2.5V3.125H4.625C4.29348 3.125 3.97554 3.2567 3.74112 3.49112C3.5067 3.72554 3.375 4.04348 3.375 4.375V17.5C3.375 17.8315 3.5067 18.1495 3.74112 18.3839C3.97554 18.6183 4.29348 18.75 4.625 18.75H15.875C16.2065 18.75 16.5245 18.6183 16.7589 18.3839C16.9933 18.1495 17.125 17.8315 17.125 17.5V4.375C17.125 4.04348 16.9933 3.72554 16.7589 3.49112C16.5245 3.2567 16.2065 3.125 15.875 3.125ZM7.75 2.5H12.75V5H7.75V2.5ZM15.875 17.5H4.625V4.375H6.5V6.25H14V4.375H15.875V17.5Z"
                                                    fill="black" />
                                            </svg>
                                        </i>

                                        <i v-if="scope.row.status == 1"
                                            @click="confirmRemoveService(scope.row.id, scope.row.delete_url)"
                                            style="cursor:pointer; padding-left: 8px">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22"
                                                viewBox="0 0 20 22" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M3.21578 4.03415C5.22033 3.83171 7.22512 3.73047 9.23005 3.73047C12.5954 3.73047 15.9701 3.90176 19.324 4.23412C19.7362 4.27497 20.0372 4.64224 19.9964 5.05443C19.9555 5.46663 19.5883 5.76766 19.1761 5.72681C15.87 5.39918 12.5447 5.23047 9.23005 5.23047C7.27535 5.23047 5.32051 5.32919 3.36543 5.52667L3.36323 5.52689L1.32323 5.72689C0.910996 5.76731 0.544048 5.46588 0.503633 5.05365C0.463218 4.64141 0.764639 4.27446 1.17688 4.23405L3.21578 4.03415Z"
                                                    fill="#2F3748" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.7097 2.78456L7.48976 4.09421C7.42116 4.50271 7.0344 4.77824 6.6259 4.70964C6.21741 4.64104 5.94187 4.25428 6.01048 3.84578L6.23048 2.53579C6.23432 2.51297 6.23828 2.48908 6.24228 2.46487C6.31114 2.04899 6.41216 1.43887 6.81885 0.977691C7.29291 0.440117 8.01621 0.25 8.94012 0.25H11.5601C12.4953 0.25 13.2178 0.455399 13.6891 0.998446C14.0963 1.46776 14.1948 2.08006 14.2606 2.48891C14.2638 2.5088 14.2669 2.52822 14.27 2.54711L14.4896 3.84486C14.5587 4.25326 14.2837 4.64037 13.8753 4.70949C13.4669 4.7786 13.0797 4.50355 13.0106 4.09514L12.7899 2.79069C12.7062 2.27767 12.6533 2.09352 12.5562 1.98155C12.5024 1.9196 12.315 1.75 11.5601 1.75H8.94012C8.17402 1.75 7.99232 1.91488 7.94389 1.96981C7.85177 2.07427 7.79978 2.24976 7.7097 2.78456Z"
                                                    fill="#2F3748" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M17.1468 7.39221C17.5601 7.41889 17.8736 7.77561 17.8469 8.18896L17.1966 18.2631L17.1953 18.2821C17.169 18.6583 17.14 19.0721 17.0625 19.457C16.9821 19.8562 16.8404 20.2775 16.5533 20.6513C15.9521 21.4339 14.929 21.7507 13.4585 21.7507H7.03846C5.5679 21.7507 4.54484 21.4339 3.94367 20.6513C3.65656 20.2775 3.51487 19.8562 3.43448 19.457C3.35695 19.0721 3.32798 18.6583 3.30163 18.2821L3.30001 18.259L2.65002 8.18896C2.62334 7.77561 2.9368 7.41889 3.35015 7.39221C3.76351 7.36553 4.12023 7.67899 4.14691 8.09234L4.79663 18.1582C4.79668 18.1589 4.79673 18.1596 4.79677 18.1603C4.825 18.563 4.84888 18.8825 4.90495 19.1609C4.95956 19.432 5.03537 19.6101 5.13326 19.7375C5.30209 19.9574 5.71903 20.2507 7.03846 20.2507H13.4585C14.7779 20.2507 15.1948 19.9574 15.3637 19.7375C15.4616 19.6101 15.5374 19.432 15.592 19.1609C15.648 18.8825 15.6719 18.563 15.7002 18.1603C15.7002 18.1596 15.7003 18.1589 15.7003 18.1582L16.35 8.09234C16.3767 7.67899 16.7334 7.36553 17.1468 7.39221Z"
                                                    fill="#2F3748" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7.82812 15.5C7.82812 15.0858 8.16391 14.75 8.57812 14.75H11.9081C12.3223 14.75 12.6581 15.0858 12.6581 15.5C12.6581 15.9142 12.3223 16.25 11.9081 16.25H8.57812C8.16391 16.25 7.82812 15.9142 7.82812 15.5Z"
                                                    fill="#2F3748" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M7 11.5C7 11.0858 7.33579 10.75 7.75 10.75H12.75C13.1642 10.75 13.5 11.0858 13.5 11.5C13.5 11.9142 13.1642 12.25 12.75 12.25H7.75C7.33579 12.25 7 11.9142 7 11.5Z"
                                                    fill="#2F3748" />
                                            </svg>
                                        </i>

                                        <i v-if="scope.row.status == 2" @click="cancelService(scope.row.id)"
                                            style="cursor:pointer; padding-left: 8px">
                                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18.7983 5.70998C18.7058 5.61728 18.5959 5.54373 18.4749 5.49355C18.3539 5.44337 18.2242 5.41754 18.0933 5.41754C17.9623 5.41754 17.8326 5.44337 17.7116 5.49355C17.5907 5.54373 17.4808 5.61728 17.3883 5.70998L12.4983 10.59L7.60827 5.69998C7.51569 5.6074 7.40578 5.53396 7.28481 5.48385C7.16385 5.43375 7.0342 5.40796 6.90327 5.40796C6.77234 5.40796 6.64269 5.43375 6.52173 5.48385C6.40076 5.53396 6.29085 5.6074 6.19827 5.69998C6.10569 5.79256 6.03225 5.90247 5.98214 6.02344C5.93204 6.1444 5.90625 6.27405 5.90625 6.40498C5.90625 6.53591 5.93204 6.66556 5.98214 6.78652C6.03225 6.90749 6.10569 7.0174 6.19827 7.10998L11.0883 12L6.19827 16.89C6.10569 16.9826 6.03225 17.0925 5.98214 17.2134C5.93204 17.3344 5.90625 17.464 5.90625 17.595C5.90625 17.7259 5.93204 17.8556 5.98214 17.9765C6.03225 18.0975 6.10569 18.2074 6.19827 18.3C6.29085 18.3926 6.40076 18.466 6.52173 18.5161C6.64269 18.5662 6.77234 18.592 6.90327 18.592C7.0342 18.592 7.16385 18.5662 7.28481 18.5161C7.40578 18.466 7.51569 18.3926 7.60827 18.3L12.4983 13.41L17.3883 18.3C17.4809 18.3926 17.5908 18.466 17.7117 18.5161C17.8327 18.5662 17.9623 18.592 18.0933 18.592C18.2242 18.592 18.3538 18.5662 18.4748 18.5161C18.5958 18.466 18.7057 18.3926 18.7983 18.3C18.8909 18.2074 18.9643 18.0975 19.0144 17.9765C19.0645 17.8556 19.0903 17.7259 19.0903 17.595C19.0903 17.464 19.0645 17.3344 19.0144 17.2134C18.9643 17.0925 18.8909 16.9826 18.7983 16.89L13.9083 12L18.7983 7.10998C19.1783 6.72998 19.1783 6.08998 18.7983 5.70998Z"
                                                    fill="#FF0707" />
                                            </svg>

                                        </i>


                                    </template>
                                </el-table-column>
                            </el-table>


                        </div>
                    </div><!-- /.card-body -->
                </div>
        >



        <el-dialog :close-on-click-modal="false" :title="$t('service.label.add service title')"
            :visible.sync="show_add_service_form">

            <el-input suffix-icon="el-icon-search" @keyup.native="searchTree" placeholder="Tìm kiếm" class="mb-3"
                      size="small" v-model="searchQuery">
            </el-input>
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


            <span slot="footer" class="dialog-footer">
                <el-button size="small" @click="show_add_service_form = false">{{ $t('common.cancel') }}</el-button>
                <el-button  size="small" type="primary" @click="confirmAddService">{{ $t('common.add') }}</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
import InlineSvg from 'vue-inline-svg';
import _ from 'lodash';
import Form from "form-backend-validation";
//you need to import the CSS manually
export default {
    components: {
        InlineSvg,
    },
    props: {
        patient_id: { default: null },
        examination_id: { default: null },
        show_add_icon: { default: true },
        show_print: { default: true },
        show_action: { default: true },
    },
    data() {
        return {
            old_data: [],

            show_config: false,
            show_filter: false,

            data: [],

            columnsSearch: [],

            loadingImport: 0,
            show_import: false,
            data_export: [],
            show_add_service_form: false,
            service_selecteds: [],
            options: [],
            tree_data: [],
            defaultProps: {
                children: 'children',
                label: 'label'
            },
            searchQuery: ''

        };
    },
    methods: {
        changeService(data, checked, indeterminate) {
            this.service_selecteds = this.$refs.tree_service.getCheckedKeys(true)
        },
        searchTree: _.debounce(function (query) {

            this.getServiceOptions();
        }, 300),

        deleteRow(index) {
            this.data.splice(index, 1);
        },
        addItem() {
            this.data.push(_.cloneDeep(this.row_default))

        },

        queryServer(customProperties) {

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                patient: this.patient_id,
                examination_id: this.examination_id,

            };
            window.axios.get(route('api.patient.examinationService', _.merge(properties, customProperties)))
                .then((response) => {
                    this.tableIsLoading = false;
                    this.tableIsLoading = false;
                    this.data = response.data.data;
                    this.meta = response.data.meta;
                    this.links = response.data.links;
                    this.order_meta.order_by = properties.order_by;
                    this.order_meta.order = properties.order;
                    this.show_filter = false;
                });
        },


        confirmAddService() {



            let routeUri = route('api.patient.addService', { patient: this.patient_id });
            const vm = this;

            const params = { list_service: this.service_selecteds }
            window.axios.post(routeUri, params)
                .then((response) => {
                    if (response.data.errors === false) {
                        vm.$notify({
                            type: 'success',
                            title: 'Thành công',
                            message: response.data.message,
                        });
                        this.service_selecteds = [];
                        this.show_add_service_form = false;
                        this.fetchData();

                    }
                })
                .catch((error) => {

                    vm.$notify({
                        type: 'error',
                        title: 'Thất bại',
                        message: error.data.message,
                    });
                })
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

        confirmRemoveService(examination_service_id, delete_url) {
            this.$confirm('Bạn có chắc chắn muốn xóa dịch vụ này?', 'Xoá dịch vụ', {
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                type: 'warning'
            }).then(() => {
                this.removeService(examination_service_id, delete_url)
            }).catch(() => {
                this.$notify({
                    type: 'error',
                    title: 'Xóa dịch vụ thất bại',
                    message: 'Đã xảy ra lỗi không mong muốn, vui lòng thử lại.'
                });
            });
        },
        removeService(examination_service_id, delete_url) {
            const vm = this;
            let routeUri = route('api.patient.deleteService', { patient: this.patient_id, examination_service_id: examination_service_id });

            window.axios.delete(routeUri)
                .then((response) => {
                    if (response.data.errors === false) {

                        vm.$notify({
                            type: 'success',
                            title: 'Thành công',
                            message: response.data.message,
                        });

                        this.fetchData();

                    } else {
                        vm.$notify({
                            type: 'error',
                            title: 'Không thành công',
                            message: response.data.message,
                        });

                    }
                })
                .catch((error) => {

                    this.$notify({
                        type: 'error',
                        title: 'Thất bại',
                        message: error.data.message,
                    });
                });
        },

        cancelService(examination_service_id) {
            const vm = this;
            let routeUri = route('api.patient.cancelService', { patient: this.patient_id, examination_service_id: examination_service_id });

            window.axios.post(routeUri)
                .then((response) => {
                    if (response.data.errors === false) {

                        vm.$notify({
                            type: 'success',
                            title: 'Thành công',
                            message: response.data.message,
                        });

                        this.fetchData();

                    } else {
                        vm.$notify({
                            type: 'error',
                            title: 'Không thành công',
                            message: response.data.message,
                        });

                    }
                })
                .catch((error) => {

                    this.$notify({
                        type: 'error',
                        title: 'Thất bại',
                        message: error.data.message,
                    });
                });
        },

        detailService(id) {

        },

        printServiceDesignation() {
            let routeUri = route('api.patient.print_service_designation', { patient: this.patient_id });
            const vm = this;

            const params = { examination_id: this.examination_id }
            window.axios.post(routeUri, params, {
                responseType: 'arraybuffer', // Add this option for binary data (e.g., for downloading files)
            })
                .then((response) => {
                    const blob = new Blob([response.data], { type: 'application/pdf' });
                    const blobUrl = window.URL.createObjectURL(blob);

                    window.open(blobUrl, '_blank');
                })
                .catch((error) => {

                    vm.$notify({
                        type: 'error',
                        title: 'Thất bại',
                        message: error.data.message,
                    });
                })
        },
        indexMethod(index) {
            if (!this.tableIsLoading) {
                return index + (this.meta.current_page - 1) * this.meta.per_page + 1;
            }
        }


    },
    mounted() {
        if (this.patient_id) {
            this.fetchData();
        }
        this.getServiceOptions();

    },
    watch: {
        data: function () {
            this.$emit("update-service-list", this.data);
        },
    },
}
</script>

<style scoped>
.disabled {
    pointer-events: none;

}
</style>
