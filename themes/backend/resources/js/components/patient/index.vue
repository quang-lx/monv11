<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('patient.label.title') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-8   ">
                        <router-link :to="{ name: 'admin.patient.create' }" class="f-action ">
                            <i class="el-icon-plus"></i>

                            {{ $t('patient.label.create_patient') }}

                        </router-link>

                        <span class="f-action pl-4 f-pointer" @click="show_filter = true">
                            <inline-svg src="/images/filter.svg" /> Bộ lọc

                        </span>
                        <span class="f-action pl-4 f-pointer" @click="show_config = true">
                            <inline-svg src="/images/list.svg" /> Tuỳ chỉnh

                        </span>

                        <span class="f-action pl-4 f-pointer" @click="exportPatients">
                            <inline-svg src="/images/download.svg" /> Tải xuống

                        </span>

                        <span class="f-action pl-4 f-pointer" @click="show_import = true">
                            <inline-svg src="/images/upload.svg" /> Import

                        </span>

                    </div>
                    <div class="col-md-4">

                        <el-input suffix-icon="el-icon-search" @keyup.native="performSearch" placeholder="Tìm kiếm"
                            size="medium" v-model="searchQuery">
                        </el-input>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="sc-table">

                                    <el-table :data="data" stripe style="width: 100%" ref="dataTable"
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange"
                                        @selection-change="handleSelectionChange">
                                        <el-table-column v-for="col_selected in list_selected_col"
                                            :key="col_selected.col_name" :prop="col_selected.col_name"
                                            :label="list_col_label[col_selected.col_name]" min-width="150">
                                            <template slot-scope="scope">
                                                    <span v-if="col_selected.col_name == 'sex'">{{
                                                        scope.row.sex_text }}</span>
                                                    <span v-else-if="col_selected.col_name == 'status'">{{
                                                        scope.row.status_text }}</span>
                                                    <span v-else> {{ scope.row[col_selected.col_name] }}</span>
                                            </template>


                                        </el-table-column>


                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <i @click="onReExamination(scope.row.id)" role="button" class="el-icon-refresh-right mr-2"></i>
                                                <edit-button
                                                    :to="{ name: 'admin.patient.edit', params: { patientId: scope.row.id } }"></edit-button>
                                                <reload-delete-button :scope="scope"
                                                    message-confirm="Bệnh sẽ bị xoá hoàn toàn khỏi hệ thống, bạn có chắc chắn xoá bệnh này?"
                                                    title="Xoá bệnh?" :rows="data"
                                                    @delete-done="queryServer"></reload-delete-button>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <div class="pagination-wrap" style="text-align: center; padding-top: 20px;"
                                        v-if="$isMobile()">
                                        <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                                            :current-page.sync="meta.current_page" :page-sizes="[6, 12, 24, 48]"
                                            :page-size="parseInt(meta.per_page)" layout="total,   prev, pager, next"
                                            :total="meta.total">
                                        </el-pagination>
                                    </div>
                                    <div class="pagination-wrap" style="text-align: center; padding-top: 20px;" v-else>
                                        <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                                            :current-page.sync="meta.current_page" :page-sizes="[25, 50, 75, 100]"
                                            :page-size="parseInt(meta.per_page)"
                                            layout="total, sizes, prev, pager, next, jumper" :total="meta.total">
                                        </el-pagination>
                                    </div>

                                </div>
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <popup-import :show_import="show_import" :loadingImport="loadingImport" @on-import="onImportPatients"
            url_template="/excel-template/Patient_Template.xlsx" @close-popup="closeImport"
            :data_export="data_export"></popup-import>

        <filter-form :show_filter="show_filter" @on-filter="onFilter" @close-popup="closeFilter"></filter-form>

        <config-display-component :list_all_col="full_col_name" table_name="patient" :show_config="show_config"
            @on-save-config="onSaveConfigDisplay" @close-popup="closeConfig"></config-display-component>

    </div>
</template>

<script>
import InlineSvg from 'vue-inline-svg';
import _ from 'lodash';
import Form from "form-backend-validation";
import FilterForm from './filter_form';
import PopupImport from '../utils/PopupImport';
import ConfigDisplayComponent from "../utils/ConfigDisplayComponent";

export default {
    components: {
        InlineSvg,
        FilterForm,
        PopupImport,
        ConfigDisplayComponent
    },
    computed: {
        isShowCol: function () {
            return this.list_selected_col.reduce(
                (obj, item) => Object.assign(obj, { [item.col_name]: 1 }), {});
        },

        list_col_label: function () {
            return this.convertArrayToObject(this.full_col_name, 'col_name', 'name')

        },

    },
    data() {
        return {
            list_selected_col: [],


            full_col_name: [

                {
                    col_name: 'id',
                    name: this.$t('patient.label.id'),

                },
                {
                    col_name: 'name',
                    name: this.$t('patient.label.name'),

                },
                {
                    col_name: 'sex',
                    name: this.$t('patient.label.sex'),

                },
                {
                    col_name: 'birthday',
                    name: this.$t('patient.label.birthday'),

                },
                {
                    col_name: 'phone',
                    name: this.$t('patient.label.phone'),

                },
                {
                    col_name: 'papers',
                    name: this.$t('patient.label.papers'),

                },
                {
                    col_name: 'job',
                    name: this.$t('patient.label.job'),

                },
                {
                    col_name: 'created_at',
                    name: this.$t('patient.label.created_at'),

                },
                {
                    col_name: 'address',
                    name: this.$t('patient.label.address'),

                },
                {
                    col_name: 'status',
                    name: this.$t('patient.label.status'),

                },
                {
                    col_name: 'data_sources',
                    name: this.$t('patient.label.data_sources'),

                }
            ],
            show_config: false,
            show_filter: false,
            addForm: new Form(),
            editForm: new Form(),

            loadingAdd: false,
            loadingEdit: false,

            data: [],

            columnsSearch: [],

            loadingImport: 0,
            show_import: false,
            data_export: [],
            multipleSelection: [],
            filter_data: [],

        };
    },
    methods: {

        closeFilter() {
            this.show_filter = false;
        },

        onFilter(filter_data) {
            this.filter_data = filter_data;
            this.queryServer(filter_data)
        },

        handleSelectionChange(val) {
            this.multipleSelection = val;
        },
        onSaveConfigDisplay(config_data) {
            this.show_config = false;
            this.list_selected_col = config_data
        },
        closeConfig() {
            this.show_config = false;
        },
        queryServer(customProperties) {

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: 1
            };

            window.axios.get(route('api.patient.index', _.merge(properties, customProperties)))
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

        closeImport() {
            this.show_import = false;
            this.loadingImport = 0;
        },

        exportPatients() {

            const properties = {
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: 1
            };

            window.axios.post(route('api.patient.exports'), {
                ...properties,
                ...this.filter_data
            })
                .then((response) => {
                    var link = document.createElement('a');

                    link.href = response.data.fileUrl;
                    link.target = '_blank';
                    link.click();
                });
        },

        onImportPatients(file) {
            this.loadingImport = 1;
            let formData = new FormData();
            formData.append("file", file);
            axios
                .post(route('api.patient.imports'), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.loadingImport = 2;
                    this.$message({
                        type: "success",
                        message: response.data.message,
                    });
                    this.data_export = response.data
                    this.fetchData();

                })
                .catch((err) => {
                    this.loadingImport = 0
                    this.data_export = err.response.data
                    this.loading = false;
                });
        },

        onReExamination(id) {
            window.axios.post(route('api.patient.change_status'), { id: id, status: 1 })
                .then((response) => {
                    if (!response.data.errors) {
                        this.$notify({
                            type: 'success',
                            title: 'Tái khám thành công',
                            message: response.data.message,
                        });
                        this.$router.push({ name: 'admin.patient.index' });
                    } else {
                        this.$notify({
                            type: 'error',
                            title: 'Lỗi',
                            message: response.data.message,
                        });
                    }
                });
        },

    },
    mounted() {
        this.fetchData();


    },
    created() {


    }
}
</script>

<style scoped>
.disabled {
    pointer-events: none;

}
</style>
