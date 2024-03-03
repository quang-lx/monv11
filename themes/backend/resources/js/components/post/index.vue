<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('post.label.title') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-8   ">
                        <router-link :to="{ name: 'admin.post.create' }" class="f-action ">
                            <i class="el-icon-plus"></i>

                            {{ $t('post.label.button_create') }}

                        </router-link>


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
                                        
                                        <el-table-column prop="name" :label="$t('post.label.name')">
                                        </el-table-column>

                                        <el-table-column prop="option" :label="$t('post.label.option')">
                                        </el-table-column>

                                        <el-table-column prop="sex_name" :label="$t('post.label.sex')">
                                        </el-table-column>



                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <edit-button
                                                    :to="{ name: 'admin.post.edit', params: { postId: scope.row.id } }"></edit-button>
                                                <reload-delete-button :scope="scope"
                                                    message-confirm="Các thông tin này sẽ bị xóa và không thể hoàn tác."
                                                    title="XÓA THIẾT BỊ?" :rows="data"
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
            };

            window.axios.get(route('api.post.index', _.merge(properties, customProperties)))
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
