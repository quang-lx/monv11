<template>
    <div>

        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <h4>{{ $t('user.label.users') }}</h4>
                    <hr>

                </div>

            </div>
        </div>


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row justify-content-between mb-2">
                    <div class="col-md-4   ">
                        <router-link :to="{name: 'admin.users.create'}" class="float-sm-left">
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
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title">
                                    {{ $t('department.label.title') }}
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <i class="el-icon-plus"></i>
                                            <i class="el-icon-edit"></i>

                                            <i class="el-icon-delete"></i>
                                        </li>

                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <el-input
                                    placeholder="Tìm kiếm"
                                    size="medium"
                                    v-model="filterDepartment">
                                </el-input>

                                <el-tree
                                    class="filter-tree"
                                    :data="departmentTreeData"
                                    :props="treeProps"
                                    default-expand-all
                                    :filter-node-method="filterNode"
                                    ref="tree">
                                </el-tree>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
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
                                        <el-table-column prop="id" :label="$t('user.label.id')" width="75"  >

                                        </el-table-column>
                                        <el-table-column prop="username" :label="$t('user.label.username')"  > </el-table-column>
                                        <el-table-column prop="name" :label="$t('user.label.name')"  >

                                        </el-table-column>
                                        <el-table-column prop="email" :label="$t('user.label.email')"  >

                                        </el-table-column>

                                        <el-table-column prop="updated_at" :label="$t('user.label.updated_at')"  >

                                        </el-table-column>

                                        <el-table-column prop="actions"  :label="$t('common.action')"  width="130">
                                            <template slot-scope="scope">
                                                <edit-button
                                                        :to="{name: 'admin.users.edit', params: {userId: scope.row.id}}"></edit-button>
                                                <delete-button :scope="scope" :rows="data"></delete-button>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <div class="pagination-wrap">
                                        <el-pagination
                                            @size-change="handleSizeChange"
                                            @current-change="handleCurrentChange"
                                            :current-page.sync="meta.current_page"
                                            :page-sizes="[25, 50, 75, 100]"
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
                treeProps: {
                    children: 'children',
                    label: 'label'
                },
                data: [],

                columnsSearch: [],
                departmentTreeData: [],
                departmentLoading: false,
                filterDepartment: '',
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

               window.axios.get(route('api.users.index', _.merge(properties, customProperties)))
                    .then((response) => {
                        this.tableIsLoading = false;
                        this.tableIsLoading = false;
                        this.data = response.data.data;
                        this.meta = response.data.meta;
                        this.links = response.data.links;
                        this.order_meta.order_by = properties.order_by;
                        this.order_meta.order = properties.order;
                    });
            },
            getDepartmentList(customProperties) {

                const properties = {

                };
                this.departmentLoading = true;
                window.axios.get(route('api.department.tree', _.merge(properties, customProperties)))
                    .then((response) => {
                        console.log(response)
                        this.departmentLoading = false;
                        this.departmentTreeData = response.data;

                    });
            },
            filterNode(value, data) {
                if (!value) return true;
                return data.label.indexOf(value) !== -1;
            }

        },
        mounted() {
            this.fetchData();
            this.getDepartmentList({});

        },
    }
</script>

<style scoped>

</style>
