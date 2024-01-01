<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('examination.label.title') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-8   ">


                        <span class="f-action pl-4 f-pointer" @click="show_filter = true">
                            <inline-svg src="/images/filter.svg" /> Bộ lọc

                        </span>
                        <span class="f-action pl-4 f-pointer" :style="{ color: '#4B67E2 !important' }" @click="show_config = true">
                            <inline-svg  src="/images/list_blue.svg" /> Tuỳ chỉnh

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
                                                    <span v-if="col_selected.col_name == 'patient.sex'">{{
                                                        scope.row.patient.sex_text }}</span>
                                                    <span v-else-if="col_selected.col_name == 'status'" class="status_border" :style="{ background: scope.row.status_color }">{{
                                                        scope.row.status_text }}</span>
                                                    <span v-else> {{getObjetValue(scope.row, col_selected.col_name)  }}</span>
                                            </template>


                                        </el-table-column>


                                        <el-table-column prop="actions" :label="$t('common.action')" width="150"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <i @click="onStartExamination(scope.row.id, scope.$index)" role="button" class=" mr-2" v-if="scope.row.status == 'init'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                                        <path d="M10.1471 16.4357L15.4952 12.2384C15.531 12.2101 15.5598 12.174 15.5797 12.133C15.5995 12.0919 15.6098 12.0469 15.6098 12.0013C15.6098 11.9558 15.5995 11.9108 15.5797 11.8697C15.5598 11.8287 15.531 11.7926 15.4952 11.7643L10.1471 7.56429C9.9486 7.40893 9.65625 7.54822 9.65625 7.8V16.1973C9.65625 16.4491 9.9486 16.5911 10.1471 16.4357Z" fill="black"/>
                                                        <path d="M21.8877 1.28613H2.14734C1.6726 1.28613 1.28906 1.66917 1.28906 2.14328V21.8576C1.28906 22.3317 1.6726 22.7147 2.14734 22.7147H21.8877C22.3624 22.7147 22.746 22.3317 22.746 21.8576V2.14328C22.746 1.66917 22.3624 1.28613 21.8877 1.28613ZM20.8149 20.7861H3.22019V3.2147H20.8149V20.7861Z" fill="black"/>
                                                    </svg>
                                                </i>
                                                <i disabled role="button" class=" mr-2" v-else>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                                        <path d="M10.1552 16.4357L15.5069 12.2384C15.5427 12.2101 15.5715 12.174 15.5914 12.133C15.6113 12.0919 15.6216 12.0469 15.6216 12.0013C15.6216 11.9558 15.6113 11.9108 15.5914 11.8697C15.5715 11.8287 15.5427 11.7926 15.5069 11.7643L10.1552 7.56429C9.95661 7.40893 9.66406 7.54822 9.66406 7.8V16.1973C9.66406 16.4491 9.95661 16.5911 10.1552 16.4357Z" fill="black" fill-opacity="0.3"/>
                                                        <path d="M21.9013 1.28613H2.14791C1.67286 1.28613 1.28906 1.66917 1.28906 2.14328V21.8576C1.28906 22.3317 1.67286 22.7147 2.14791 22.7147H21.9013C22.3764 22.7147 22.7602 22.3317 22.7602 21.8576V2.14328C22.7602 1.66917 22.3764 1.28613 21.9013 1.28613ZM20.8278 20.7861H3.22146V3.2147H20.8278V20.7861Z" fill="black" fill-opacity="0.3"/>
                                                    </svg>

                                                </i>

                                                <edit-button
                                                    :to="{ name: 'admin.patientexamination.edit', params: { patientexaminationId: scope.row.id } }"></edit-button>

                                                <i @click="onFinishExamination(scope.row.id, scope.$index)" role="button" class=" mr-2" v-if="scope.row.status == 'processing'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 22" fill="none">
                                                        <path d="M16.3228 7.0957H15.1197C14.8581 7.0957 14.6093 7.21602 14.4553 7.42227L10.4229 12.7749L8.59644 10.3491C8.44253 10.1453 8.19627 10.0225 7.93205 10.0225H6.72898C6.56224 10.0225 6.46476 10.2042 6.56224 10.3343L9.75847 14.5772C9.83398 14.6781 9.93352 14.7602 10.0488 14.8169C10.1642 14.8737 10.2919 14.9032 10.4216 14.9032C10.5512 14.9032 10.679 14.8737 10.7943 14.8169C10.9096 14.7602 11.0092 14.6781 11.0847 14.5772L16.487 7.40753C16.587 7.2774 16.4895 7.0957 16.3228 7.0957Z" fill="black"/>
                                                        <path d="M11.5233 0C5.17703 0 0.03125 4.92545 0.03125 11C0.03125 17.0746 5.17703 22 11.5233 22C17.8696 22 23.0154 17.0746 23.0154 11C23.0154 4.92545 17.8696 0 11.5233 0ZM11.5233 20.1339C6.25441 20.1339 1.9808 16.0433 1.9808 11C1.9808 5.9567 6.25441 1.86607 11.5233 1.86607C16.7922 1.86607 21.0658 5.9567 21.0658 11C21.0658 16.0433 16.7922 20.1339 11.5233 20.1339Z" fill="black"/>
                                                    </svg>
                                                </i>
                                                <i disabled role="button" class=" mr-2" v-else>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 22" fill="none">
                                                        <path d="M16.3228 7.0957H15.1197C14.8581 7.0957 14.6093 7.21602 14.4553 7.42227L10.4229 12.7749L8.59644 10.3491C8.44253 10.1453 8.19627 10.0225 7.93205 10.0225H6.72898C6.56224 10.0225 6.46476 10.2042 6.56224 10.3343L9.75847 14.5772C9.83398 14.6781 9.93352 14.7602 10.0488 14.8169C10.1642 14.8737 10.2919 14.9032 10.4216 14.9032C10.5512 14.9032 10.679 14.8737 10.7943 14.8169C10.9096 14.7602 11.0092 14.6781 11.0847 14.5772L16.487 7.40753C16.587 7.2774 16.4895 7.0957 16.3228 7.0957Z" fill="black" fill-opacity="0.3"/>
                                                        <path d="M11.5233 0C5.17703 0 0.03125 4.92545 0.03125 11C0.03125 17.0746 5.17703 22 11.5233 22C17.8696 22 23.0154 17.0746 23.0154 11C23.0154 4.92545 17.8696 0 11.5233 0ZM11.5233 20.1339C6.25441 20.1339 1.9808 16.0433 1.9808 11C1.9808 5.9567 6.25441 1.86607 11.5233 1.86607C16.7922 1.86607 21.0658 5.9567 21.0658 11C21.0658 16.0433 16.7922 20.1339 11.5233 20.1339Z" fill="black" fill-opacity="0.3"/>
                                                    </svg>
                                                </i>

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
                                            :current-page.sync="meta.current_page" :page-sizes="[20, 40, 60, 80, 100]"
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


        <filter-form :show_filter="show_filter" @on-filter="onFilter" @close-popup="closeFilter"></filter-form>

        <config-display-component :list_all_col="full_col_name" table_name="examination" :show_config="show_config"
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
                    col_name: 'patient.name',
                    name: this.$t('patient.label.name'),

                },
                {
                    col_name: 'patient.sex',
                    name: this.$t('patient.label.sex'),

                },
                {
                    col_name: 'patient.birthday',
                    name: this.$t('patient.label.birthday'),

                },
                {
                    col_name: 'patient.phone',
                    name: this.$t('patient.label.phone'),

                },
                {
                    col_name: 'patient.papers',
                    name: this.$t('patient.label.papers'),

                },
                {
                    col_name: 'patient.job',
                    name: this.$t('patient.label.job'),

                },

                {
                    col_name: 'patient.address',
                    name: this.$t('patient.label.address'),

                },
                {
                    col_name: 'started_at',
                    name: this.$t('examination.label.started_at'),

                },
                {
                    col_name: 'finished_at',
                    name: this.$t('examination.label.finished_at'),

                },
                {
                    col_name: 'diagnose',
                    name: this.$t('examination.label.diagnose'),

                },
                {
                    col_name: 'status',
                    name: this.$t('examination.label.status'),

                },
                {
                    col_name: 'created_at',
                    name: this.$t('patient.label.created_at'),

                },

                {
                    col_name: 'created_by_info',
                    name: this.$t('examination.label.created_by'),

                },
                {
                    col_name: 'count_service',
                    name: this.$t('examination.label.service'),

                },


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

            };

            window.axios.get(route('api.patientexamination.index', _.merge(properties, customProperties)))
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

        onStartExamination(id, index) {
            window.axios.post(route('api.patientexamination.startExamination', {patientexamination: id}))
                .then((response) => {
                    if (!response.data.errors) {
                        this.$notify({
                            type: 'success',

                            message: response.data.message,
                        });
                         this.data.splice(index,1, response.data.model)

                    } else {
                        this.$notify({
                            type: 'error',
                            message: response.data.message,
                        });
                    }
                });
        },

        onFinishExamination(id, index){
            window.axios.post(route('api.patientexamination.finishExamination', {patientexamination: id}))
                .then((response) => {
                    if (!response.data.errors) {
                        this.$notify({
                            type: 'success',

                            message: response.data.message,
                        });

                        this.data.splice(index,1, response.data.model)

                    } else {
                        this.$notify({
                            type: 'error',
                            message: response.data.message,
                        });
                    }
                });
        }

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
