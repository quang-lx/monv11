<template>
    <div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="f-box-title  d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.747451 0.494141H19.2474C19.5265 0.494141 19.7527 0.720355 19.7527 0.999404V14.7494C19.7527 15.0285 19.5265 15.2547 19.2474 15.2547H0.747451C0.468402 15.2547 0.242188 15.0285 0.242188 14.7494V0.999404C0.242188 0.720355 0.468402 0.494141 0.747451 0.494141ZM18.742 14.2439V1.50465H1.2527V14.2439H18.742Z" fill="#252525"/>
                                <path d="M2.99219 8.5027L2.997 7.49219L17.0075 7.5589L17.0027 8.56942L2.99219 8.5027Z" fill="#252525"/>
                                <path d="M2.99219 10.5632L2.997 9.55273L17.0075 9.61945L17.0027 10.63L2.99219 10.5632Z" fill="#252525"/>
                                <path d="M2.99219 12.6257L2.997 11.6152L17.0075 11.6819L17.0027 12.6925L2.99219 12.6257Z" fill="#252525"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.49745 2.99414H9.74745C10.0265 2.99414 10.2527 3.22035 10.2527 3.4994V5.9994C10.2527 6.27845 10.0265 6.50467 9.74745 6.50467H3.49745C3.2184 6.50467 2.99219 6.27845 2.99219 5.9994V3.4994C2.99219 3.22035 3.2184 2.99414 3.49745 2.99414ZM9.24195 5.4939V4.00465H4.0027V5.4939H9.24195Z" fill="#252525"/>
                            </svg>
                            <span class="f-text-title pl-1 pr-2"> Chỉ số con</span>

                        </div>

                        <div class="row justify-content-between mb-2">
                            <div class="col-md-8">

                                    <el-input class="col-5" suffix-icon="el-icon-search" @keyup.native="performSearch"
                                              placeholder="Tìm kiếm chỉ số" size="small" v-model="searchQuery">
                                    </el-input>



                            </div>
                            <div class="col-md-4 d-flex flex-row align-items-center d-flex justify-content-end">


                                <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                                               :current-page.sync="meta.current_page"
                                               :page-sizes="[20, 40, 60, 80, 100]"
                                               :page-size="parseInt(meta.per_page)" layout="sizes, prev, pager, next"
                                               :total="meta.total"
                                               v-if="meta.total > 25">
                                </el-pagination>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-12">


                                <div class="sc-table">

                                    <el-table :data="lis_data" stripe style="width: 100%" ref="dataTable"
                                              v-loading.body="tableIsLoading" @sort-change="handleSortChange">

                                        <el-table-column :label="$t('common.stt')" width="75"
                                                         type="index"></el-table-column>


                                        <el-table-column :label="$t('service.label.code')" width="120">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.code}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column :label="$t('service.label.code_lis')" width="120">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.code_lis}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="name" :label="$t('service.label.name')"
                                                         min-width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.name}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="min_value" :label="$t('service.label.min_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.min_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="max_value" :label="$t('service.label.max_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.max_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="ref_value" :label="$t('service.label.ref_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.ref_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="unit" :label="$t('service.label.unit')" width="100">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.unit}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="male_min_value"
                                                         :label="$t('service.label.male_min_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.male_min_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="male_max_value"
                                                         :label="$t('service.label.male_max_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.male_max_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="female_min_value"
                                                         :label="$t('service.label.female_min_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.female_min_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="female_max_value"
                                                         :label="$t('service.label.female_max_value')"
                                                         width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.female_max_value}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="ket_qua" label="Kết quả" width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.ket_qua}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="ket_luan" label="Kết luận" width="150">
                                            <template slot-scope="scope">

                                                <span style="background: #F2C5C5;">
                                                     {{scope.row.ket_qua}}

                                                </span>
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

    </div>
</template>

<script>
    import InlineSvg from 'vue-inline-svg';
    import _ from 'lodash';

    export default {
        components: {
            InlineSvg,

        },
        props: {
            examination_service_id: {default: null}
        },
        data() {
            return {


                lis_data: [],
                columnsSearch: [],

                loadingImport: 0,
                show_import: false,
                data_export: [],


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
                    examination_service_id: this.examination_service_id,


                };

                window.axios.get(route('api.examinationindex.index', _.merge(properties, customProperties)))
                    .then((response) => {
                        this.tableIsLoading = false;
                        this.tableIsLoading = false;
                        this.lis_data = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;
                        this.order_meta.order_by = properties.order_by;
                        this.order_meta.order = properties.order;

                    });
            },


        },
        mounted() {
            this.fetchData();

        },
        watch: {},
    }
</script>

<style scoped>
    .disabled {
        pointer-events: none;

    }
</style>
