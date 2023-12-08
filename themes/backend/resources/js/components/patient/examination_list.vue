<template>
    <div>

        <div class="card">
            <div class="card-body">

                <div class="row justify-content-between mb-2">
                    <div class="col-md-6">
                        <div class="row d-flex flex-row align-items-center">

                        </div>

                    </div>
                    <div class="col-md-6 d-flex flex-row align-items-center d-flex justify-content-end">

                        <div class="d-flex flex-column">
                            <span class=" mb-1">Thời gian khám</span>
                            <el-date-picker
                                size="small"
                                v-model="filter_date_range"
                                type="daterange"
                                range-separator="-"
                                start-placeholder="Chọn thời gian khám"
                                end-placeholder=""
                                format="dd/MM/yyyy"
                                value-format="yyyy-MM-dd"
                                @change="queryServer({})"
                                >
                            </el-date-picker>
                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="sc-table">

                                    <el-table :data="data" stripe style="width: 100%" ref="dataTable"
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange">
                                        <el-table-column :label="$t('service.label.stt')" type="index" width="100" align="center">
                                        </el-table-column>
                                        <el-table-column prop="started_at" label="Thời gian bắt đầu" min-width="180"  >
                                        </el-table-column>

                                        <el-table-column prop="finished_at" label="Thời gian kết thúc" min-width="180"  >
                                        </el-table-column>
                                        <el-table-column prop="count_service" label="Dịch vụ" min-width="120"  >
                                        </el-table-column>
                                        <el-table-column prop="code" label="Chẩn đoán"   >
                                        </el-table-column>

                                        <el-table-column prop="status" :label="$t('patient_has_service.label.status')" align="center"
                                            min-width="150">
                                            <template slot-scope="scope">
                                                <span class="status_border"  :style="{ background: scope.row.status_color }"> {{scope.row.status_text}}</span>
                                            </template>
                                        </el-table-column>


                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                             >
                                            <template slot-scope="scope">
                                                <i    @click="detailService(scope.row.id)" style = "cursor:pointer; padding-left: 8px">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                                                        <path d="M9 14.375H14V15.625H9V14.375ZM6.5 14.375H7.75V15.625H6.5V14.375ZM9 11.25H14V12.5H9V11.25ZM6.5 11.25H7.75V12.5H6.5V11.25ZM9 8.125H14V9.375H9V8.125ZM6.5 8.125H7.75V9.375H6.5V8.125Z" fill="black"/>
                                                        <path d="M15.875 3.125H14V2.5C14 2.16848 13.8683 1.85054 13.6339 1.61612C13.3995 1.3817 13.0815 1.25 12.75 1.25H7.75C7.41848 1.25 7.10054 1.3817 6.86612 1.61612C6.6317 1.85054 6.5 2.16848 6.5 2.5V3.125H4.625C4.29348 3.125 3.97554 3.2567 3.74112 3.49112C3.5067 3.72554 3.375 4.04348 3.375 4.375V17.5C3.375 17.8315 3.5067 18.1495 3.74112 18.3839C3.97554 18.6183 4.29348 18.75 4.625 18.75H15.875C16.2065 18.75 16.5245 18.6183 16.7589 18.3839C16.9933 18.1495 17.125 17.8315 17.125 17.5V4.375C17.125 4.04348 16.9933 3.72554 16.7589 3.49112C16.5245 3.2567 16.2065 3.125 15.875 3.125ZM7.75 2.5H12.75V5H7.75V2.5ZM15.875 17.5H4.625V4.375H6.5V6.25H14V4.375H15.875V17.5Z" fill="black"/>
                                                    </svg>
                                                </i>




                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <div class="pagination-wrap" style="text-align: center; padding-top: 20px;"  >
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
        </div>


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
        patient_id: { default: null },
    },
    data() {
        return {
            old_data: [],

            show_config: false,
            show_filter: false,

            data: [],
            filter_date_range: null,

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


        queryServer(customProperties) {

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                patient_id: this.patient_id,
                filter_date_range: this.filter_date_range

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


        detailService(id) {

        }


    },
    mounted() {
        if (this.patient_id) {
            this.fetchData();
        }


    },
    watch: {

    },
}
</script>

