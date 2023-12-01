<template>
    <div>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-6">
                        <div class="row d-flex flex-row align-items-center">
                            <span class="col-3">Danh sách dịch vụ</span>
                            <el-input class="col-4" suffix-icon="el-icon-search" @keyup.native="performSearch"
                                placeholder="Tìm kiếm dịch vụ" size="medium" v-model="searchQuery">
                            </el-input>
                        </div>

                    </div>
                    <div class="col-md-6 d-flex flex-row align-items-center d-flex justify-content-end">

                        <span class="f-action pl-4 f-pointer"
                            @click="() => { show_add_service_form = true, getServiceOptions() }">
                            <inline-svg src="/images/add.svg" /> {{ $t('common.add') }}

                        </span>


                        <!-- <span class="f-action pl-4 f-pointer">
                            <inline-svg src="/images/download.svg" /> Tải xuống

                        </span>

                        <span class="f-action pl-4 f-pointer">
                            <inline-svg src="/images/upload.svg" /> Tải lên

                        </span> -->

                        <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                            :current-page.sync="meta.current_page" :page-sizes="[25, 50, 75, 100]"
                            :page-size="parseInt(meta.per_page)" layout="sizes, prev, pager, next" :total="meta.total"
                            v-if="meta.total > 25">
                        </el-pagination>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="sc-table">

                                    <el-table :data="data" stripe style="width: 100%" ref="dataTable"
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange">
                                        <el-table-column :label="$t('service.label.stt')" type="index" width="100">
                                        </el-table-column>
                                        <el-table-column prop="service_id" :label="$t('service.label.id')" width="150">
                                        </el-table-column>

                                        <el-table-column prop="code" :label="$t('service.label.code')" width="150">
                                        </el-table-column>
                                        <el-table-column prop="name" :label="$t('service.label.name')" width="150">
                                        </el-table-column>
                                        <el-table-column prop="status" :label="$t('patient_has_service.label.status')"
                                            width="150">
                                        </el-table-column>
                                        <el-table-column prop="created_at"
                                            :label="$t('patient_has_service.label.created_at')" width="150">
                                        </el-table-column>
                                        <el-table-column prop="created_by"
                                            :label="$t('patient_has_service.label.created_by')" width="150">
                                        </el-table-column>

                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <i class="el-icon-delete" @click="confirmRemoveService(scope.row.id)"
                                                    style="cursor:pointer; padding-left: 8px"></i>

                                            </template>
                                        </el-table-column>
                                    </el-table>


                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <el-dialog :title="$t('service.label.add service title')" :visible.sync="show_add_service_form">

            <el-select v-model="service_selecteds" multiple filterable remote reserve-keyword
                :placeholder="$t('common.search')">
                <el-option v-for="item in options" :key="item.id" :label="item.name" :value="item.id">
                </el-option>
            </el-select>

            <span slot="footer" class="dialog-footer">
                <el-button @click="show_add_service_form = false">{{ $t('common.cancel') }}</el-button>
                <el-button type="primary" @click="confirmAddService">{{ $t('common.add') }}</el-button>
            </span>
        </el-dialog>

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
        patient_id: { default: null }
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
        };
    },
    methods: {
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
                patient_id: this.patient_id
            };

            window.axios.get(route('api.patient.patientHasService', _.merge(properties, customProperties)))
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
            let options = this.options.filter(item => {
                return this.service_selecteds.includes(item.id)
            })
            let data_format = options.map(item => {
                return {
                    id: null,
                    service_id: item.id,
                    code: item.code,
                    name: item.name,
                    status: 1,
                }
            })
            this.data = this.data.concat(data_format);
            this.service_selecteds = [];
            this.show_add_service_form = false;
        },

        getServiceOptions() {
            const properties = {
                page: 1,
                per_page: 9000,
            };

            window.axios.get(route('api.service.index', properties))
                .then((response) => {
                    let data = this.data.map((item) => item.service_id);

                    this.options = response.data.data.filter(item => {
                        return !data.includes(item.id)
                    })
                });
        },

        confirmRemoveService(service_id) {
            this.$confirm('Bạn có chắc chắn muốn xóa dịch vụ này?', 'Xoá dịch vụ', {
                confirmButtonText: 'Xoá',
                cancelButtonText: 'Huỷ',
                type: 'warning'
            }).then(() => {
                this.removeService(service_id)
                this.$notify({
                    type: 'success',
                    title: 'Xóa dịch vụ thành công',
                    message: 'Dịch vụ    đã được xóa thành công.'
                });
            }).catch(() => {
                this.$notify({
                    type: 'error',
                    title: 'Xóa dịch vụ thất bại',
                    message: 'Đã xảy ra lỗi không mong muốn, vui lòng thử lại.'
                });
            });
        },
        removeService(service_id) {
            this.data = this.data.filter(item => { return item.id != service_id })

        },


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
