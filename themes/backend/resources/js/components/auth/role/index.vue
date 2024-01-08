<template>
    <div>
        <div class="content-header">
                <div class="row ">
                    <div class="col-12">
                         <span class="f-breadcrumb">{{ $t('role.label.roles') }}</span>
                         <hr>

                    </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-4   ">
                        <router-link :to="{name: 'admin.roles.create'}" class="f-action  float-sm-left">
                            <i class="el-icon-plus"></i>

                            {{ $t('role.label.create_role') }}

                        </router-link>
                    </div>
                    <div class="col-md-4">

                        <el-input suffix-icon="el-icon-search" @keyup.native="performSearch" placeholder="Tìm kiếm"
                                  size="medium"
                                  v-model="searchQuery">
                        </el-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="sc-table">

                                    <el-table
                                        :data="data"
                                        stripe
                                        style="width: 100%"
                                        ref="dataTable"
                                        v-loading.body="tableIsLoading"
                                        @sort-change="handleSortChange">
                                        <el-table-column   :label="$t('common.stt')" width="75" :index="indexMethod" type="index" > </el-table-column>
                                        <el-table-column prop="name" :label="$t('role.label.name')"  >

                                        </el-table-column>
                                        <el-table-column prop="description" :label="$t('role.label.description')"
                                                          >

                                        </el-table-column>

                                        <el-table-column prop="updated_at" :label="$t('role.label.created_at')"
                                                          >

                                        </el-table-column>

                                        <el-table-column prop="actions"  :label="$t('common.action')"  width="100" >
                                            <template slot-scope="scope">
                                                <edit-button
                                                    :to="{name: 'admin.roles.edit', params: {roleId: scope.row.id}}"></edit-button>
                                                <reload-delete-button :scope="scope" :rows="data"
                                                                      message-confirm="Vai trò sẽ bị xoá hoàn toàn khỏi hệ thống, bạn có chắc chắn xoá vai trò này?"
                                                                      title="Xoá vai trò"
                                                                      @delete-done="queryServer"
                                                                      v-if="scope.row.name != 'cms_login'"></reload-delete-button>

                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <div class="pagination-wrap">
                                        <el-pagination
                                            @size-change="handleSizeChange"
                                            @current-change="handleCurrentChange"
                                            :current-page.sync="meta.current_page"
                                            :page-sizes="[20, 40, 60, 80, 100]"
                                            :page-size="parseInt(meta.per_page)"
                                            :layout="pagingSetting.layout"
                                            :total="meta.total">
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
    import axios from 'axios';

    export default {

        data() {
            return {
                data: [],


                columnsSearch: [],
                listFilterColumn: [],


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

                window.axios.get(route('api.roles.index', _.merge(properties, customProperties)))
                    .then((response) => {
                        this.tableIsLoading = false;
                        this.tableIsLoading = false;
                        this.data = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;
                        this.order_meta.order_by = properties.order_by;
                        this.order_meta.order = properties.order;
                    });
            }

        },
        mounted() {
            this.fetchData();

        },
        indexMethod(index) {
            if (!this.tableIsLoading) {
                return index + (this.meta.current_page - 1) * this.meta.per_page + 1;
            }
        }
    }
</script>

<style scoped>

</style>
