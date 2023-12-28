<template>
    <div>



                <div class="row justify-content-between mb-2">
                    <div class="col-md-4 d-flex flex-row align-items-center">
                        <span>Danh sách chỉ số con</span>
                        <el-input suffix-icon="el-icon-search" @keyup.native="performSearch" placeholder="Tìm kiếm chỉ số"
                                  size="small" v-model="searchQuery">
                        </el-input>
                    </div>


                </div>

                <div class="row">

                    <div class="col-md-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="sc-table">

                                    <el-table :data="lis_data" stripe style="width: 100%" ref="dataTable"
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange">

                                        <el-table-column   :label="$t('common.stt')" width="75" type="index" > </el-table-column>


                                        <el-table-column prop="code" :label="$t('service.label.code')" width="120">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.code}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="code" :label="$t('service.label.code_lis')" width="120">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.code_lis}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="name" :label="$t('service.label.name')" min-width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.name}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="min_value" :label="$t('service.label.min_value')" width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.min_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="max_value" :label="$t('service.label.max_value')" width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.max_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="ref_value" :label="$t('service.label.ref_value')" width="150">
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
                                        <el-table-column prop="male_min_value" :label="$t('service.label.male_min_value')" width="150">
                                            <template slot-scope="scope">

                                                <span >
                                                     {{scope.row.index_data.male_min_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="male_max_value" :label="$t('service.label.male_max_value')" width="150">
                                            <template slot-scope="scope">

                                                <span>
                                                     {{scope.row.index_data.male_max_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="female_min_value" :label="$t('service.label.female_min_value')" width="150">
                                            <template slot-scope="scope">

                                                <span >
                                                     {{scope.row.index_data.female_min_value}}

                                                </span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="female_max_value" :label="$t('service.label.female_max_value')" width="150">
                                            <template slot-scope="scope">

                                                <span >
                                                     {{scope.row.index_data.female_max_value}}

                                                </span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="ket_qua" label="Kết quả" width="150">
                                            <template slot-scope="scope">

                                                <span >
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
        lis_data : {default: null}
    },
    data() {
        return {


            columnsSearch: [],

            loadingImport: 0,
            show_import: false,
            data_export: [],


        };
    },
    methods: {




    },
    mounted() {



    },
    watch: {

    },
}
</script>

<style scoped>
.disabled {
    pointer-events: none;

}
</style>
