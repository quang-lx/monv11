<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('servicetype.label.title') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-8   ">
                        <router-link :to="{ name: 'admin.servicetype.create' }" class="f-action ">
                            <i class="el-icon-plus"></i>

                            {{ $t('common.add') }}

                        </router-link>


                        <span class="f-action pl-4 f-pointer" @click="exportServiceType">
                            <inline-svg src="/images/download.svg" /> Tải xuống

                        </span>

                        <span class="f-action pl-4 f-pointer" @click="show_import = true">
                            <inline-svg src="/images/upload.svg" /> Tải lên

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
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange">
                                        <el-table-column prop="code" :label="$t('servicetype.label.code')" width="200"></el-table-column>

                                        <el-table-column prop="name" :label="$t('servicetype.label.name')" min-width="250"> </el-table-column>
                                        <el-table-column prop="type" :label="$t('common.created_at')" min-width="200"></el-table-column>


                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <edit-button
                                                    :to="{ name: 'admin.servicetype.edit', params: { servicetypeId: scope.row.id } }"></edit-button>
                                                <reload-delete-button :scope="scope"
                                                    message-confirm="Các thông tin này sẽ bị xóa và không thể hoàn tác."
                                                    title="XÓA DỊCH VỤ?" :rows="data"
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


        <popup-import :show_import="show_import" :loadingImport="loadingImport" @on-import="onImportDevices" @close-popup="closeImport" url_template="/excel-template/GroupDevice_Template.xlsx" :data_export="data_export"></popup-import>

    </div>
</template>

<script>
import InlineSvg from 'vue-inline-svg';
import _ from 'lodash';
import Form from "form-backend-validation";
import PopupImport from '../utils/PopupImport';

export default {
    components: {
        InlineSvg,
        PopupImport,

    },

    data() {
        return {

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
            data_export: []

        };
    },
    methods: {


        queryServer(customProperties) {

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: 1
            };

            window.axios.get(route('api.servicetype.index', _.merge(properties, customProperties)))
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
            this.data_export = []
        },
        exportServiceType() {

            const properties = {
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: 1
            };

            window.axios.post(route('api.servicetype.exports'), properties)
                .then((response) => {
                    var link = document.createElement('a');

                    link.href = response.data.fileUrl;
                    link.target = '_blank';
                    link.click();
                });
        },

        onImportDevices(file) {
            this.loadingImport = 1;
            let formData = new FormData();
            formData.append("file", file);
            axios
                .post(route('api.servicetype.imports'), formData, {
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
