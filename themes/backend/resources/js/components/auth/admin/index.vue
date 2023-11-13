<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('user.label.users') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-4   ">
                        <router-link :to="{name: 'admin.admins.create'}" class="f-action ">
                            <i class="el-icon-plus"></i>

                            {{ $t('user.label.create_user') }}

                        </router-link>
                        <span class="f-action pl-4 f-pointer" @click="show_filter = true">
                            <inline-svg src="/images/filter.svg"  /> Bộ lọc

                        </span>
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
                                            <i class="el-icon-plus"    style="cursor:pointer" @click="showAddDepartment = true"></i>
                                            <i class="el-icon-edit" v-bind:class="{ disabled: !parent_selected }"  style="cursor:pointer"  @click="showEditDepartment = true"></i>

                                            <i class="el-icon-delete" v-bind:class="{ disabled: !parent_selected }"   style="cursor:pointer"  @click="confirmDeleteDepartment"></i>
                                        </li>

                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <el-input
                                    class="mb-2"
                                    placeholder="Tìm kiếm"
                                    size="mini"
                                    v-model="filterDepartment">
                                </el-input>

                                <el-tree
                                    class="filter-tree"
                                    :data="departmentTreeData"
                                    :props="treeProps"
                                    default-expand-all
                                    :filter-node-method="filterNode"
                                    @node-click="handleNodeClick"
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

                                        <el-table-column prop="username" fixed :label="$t('user.label.username')" width="150" sortable="custom"> </el-table-column>

                                        <el-table-column prop="name" :label="$t('user.label.name')" width="250" sortable="custom">

                                        </el-table-column>
                                        <el-table-column prop="email" :label="$t('user.label.email')" width="200"  sortable="custom">

                                        </el-table-column>
                                        <el-table-column prop="phone" :label="$t('user.label.phone')" width="130" sortable="custom">

                                        </el-table-column>
                                        <el-table-column prop="sex" :label="$t('user.label.sex')" width="120" sortable="custom">
                                            <template slot-scope="scope">
                                                <span>{{scope.row.sex_text}}</span>
                                            </template>
                                        </el-table-column>
                                        <el-table-column prop="birth_day" :label="$t('user.label.birth_day')" width="150" sortable="custom">

                                        </el-table-column>
                                        <el-table-column prop="identification" :label="$t('user.label.identification')" width="150" sortable="custom">

                                        </el-table-column>
                                        <el-table-column prop="expired_at" :label="$t('user.label.status')" width="150" sortable="custom">
                                            <template slot-scope="scope">
                                                <span>{{scope.row.status_text}}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="created_at" :label="$t('user.label.created_at')"  width="150" sortable="custom">

                                        </el-table-column>
                                        <el-table-column prop="created_by" :label="$t('user.label.created by')"  width="150" >
                                            <template slot-scope="scope">
                                                <span v-if="scope.row.createdBy">{{scope.row.createdBy.name}}</span>
                                            </template>
                                        </el-table-column>

                                        <el-table-column prop="actions"  width="130" fixed="right">
                                            <template slot-scope="scope">
                                                <edit-button
                                                        :to="{name: 'admin.admins.edit', params: {userId: scope.row.id}}"></edit-button>
                                                <reload-delete-button :scope="scope"
                                                                      message-confirm="Các thông tin này sẽ bị xóa và không thể hoàn tác."
                                                                      title="XÓA NHÂN VIÊN?"
                                                                      :rows="data"
                                                                      @delete-done="queryServer"></reload-delete-button>
                                            </template>
                                        </el-table-column>
                                    </el-table>
                                    <div class="pagination-wrap" style="text-align: center; padding-top: 20px;"  v-if="$isMobile()">
                                        <el-pagination
                                          @size-change="handleSizeChange"
                                          @current-change="handleCurrentChange"
                                          :current-page.sync="meta.current_page"
                                          :page-sizes="[6, 12, 24, 48]"
                                          :page-size="parseInt(meta.per_page)"
                                          layout="total,   prev, pager, next"
                                          :total="meta.total">
                                        </el-pagination>
                                    </div>
                                    <div class="pagination-wrap" style="text-align: center; padding-top: 20px;" v-else>
                                        <el-pagination
                                          @size-change="handleSizeChange"
                                          @current-change="handleCurrentChange"
                                          :current-page.sync="meta.current_page"
                                          :page-sizes="[25, 50, 75, 100]"
                                          :page-size="parseInt(meta.per_page)"
                                          layout="total, sizes, prev, pager, next, jumper"
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

        <el-dialog
            width="30%"
            :show-close="false"
            :title="$t('department.label.add department')"
            :destroy-on-close="true"
            :visible.sync="showAddDepartment">


            <el-form ref="addDepartmentForm"
                     :model="addModel"
                     label-position="top"
                     v-loading.body="loadingAdd"
            >
                <el-form-item label=""
                              :class="{'el-form-item is-error': addForm.errors.has('name') }">
                    <el-input v-model="addModel.name"  size="medium"></el-input>
                    <div class="el-form-item__error"
                         v-if="addForm.errors.has('name')"
                         v-text="addForm.errors.first('name')"></div>
                </el-form-item>

            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small"  @click="showAddDepartment = false">{{$t('common.cancel')}}</el-button>
                <el-button size="small" type="primary" @click="confirmAddDepartment">{{$t('common.add')}}</el-button>
              </div>
        </el-dialog>
        <el-dialog
            width="30%"
            :show-close="false"
            :title="$t('department.label.edit department')"
            :destroy-on-close="true"
            :visible.sync="showEditDepartment">


            <el-form ref="addDepartmentForm"
                     :model="editModel"
                     label-position="top"
                     v-loading.body="loadingEdit"
            >
                <el-form-item label=""
                              :class="{'el-form-item is-error': editForm.errors.has('name') }">
                    <el-input v-model="editModel.name"  size="medium"></el-input>
                    <div class="el-form-item__error"
                         v-if="editForm.errors.has('name')"
                         v-text="editForm.errors.first('name')"></div>
                </el-form-item>

            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small"  @click="showEditDepartment = false">{{$t('common.cancel')}}</el-button>
                <el-button size="small" type="primary" @click="confirmEditDepartment">Sửa</el-button>
            </div>
        </el-dialog>
        <filter-form :show_filter = "show_filter" @on-filter="onFilterUser"></filter-form>

    </div>
</template>

<script>
    import FilterForm from './filter_form';
    import InlineSvg from 'vue-inline-svg';

    import Form from "form-backend-validation";

    export default {
        components: {
            FilterForm,
            InlineSvg
        },
        data() {
            return {
                show_filter: false,
                addForm: new Form(),
                editForm: new Form(),
                parent_selected: null,
                addModel: {
                    name: '',
                    parent_id: '',


                },
                editModel: {
                    id: '',
                    name: '',


                },
                loadingAdd: false,
                loadingEdit: false,
                treeProps: {
                    children: 'children',
                    label: 'label'
                },
                data: [],
                showAddDepartment: false,
                showEditDepartment: false,
                columnsSearch: [],
                departmentTreeData: [],
                departmentLoading: false,
                filterDepartment: '',
                listFilterColumn: [],

            };
        },
        methods: {

            handleNodeClick(data, checked, indeterminate) {
                this.parent_selected = data.id
                this.editModel.id = data.id
                this.editModel.name = data.label
            },
            confirmDeleteDepartment() {
                if( this.parent_selected) {
                    this.$confirm('Thành viên trong nhóm sẽ chuyển về nhóm “Chưa xếp nhóm”', 'Bạn có chắc chắn xóa nhóm này?', {
                        confirmButtonText: 'Xoá',
                        cancelButtonText: 'Huỷ',
                        type: 'warning'
                    }).then(() => {
                        this.deleteDepartment()

                    }).catch(() => {

                    });
                }
            },
            deleteDepartment() {
                window.axios.delete(route('api.department.destroy', {department: this.parent_selected}) )
                    .then((response) => {
                        if (response.data.errors === false) {
                            this.$notify({
                                type: 'success',
                                message: response.data.message,
                            });
                            this.getDepartmentList({})

                        }else {
                            this.$notify({
                                type: 'error',
                                message: response.data.message,
                            });
                        }
                    })
                    .catch((error) => {
                        this.$notify({
                            type: 'error',
                            message: error.data.message,
                        });
                    });
            },
            confirmAddDepartment() {
                let params = _.merge(this.addModel);
                params.parent_id = this.parent_selected;
                this.form = new Form(params);
                this.loadingAdd = true;

                this.form.post(this.getRouteCreateDepartment())
                    .then((response) => {
                        this.loadingAdd = false;
                        this.$notify({
                            type: 'success',
                            message: response.message,
                        });
                        this.showAddDepartment = false;
                        this.addModel.name = '';

                        this.getDepartmentList({})
                    })
                    .catch((error) => {

                        this.loadingAdd = false;
                        this.$notify.error({
                            title: this.$t('mon.error.Title'),
                            message: this.getSubmitError(this.form.errors),
                        });
                    });
            },
            confirmEditDepartment() {
                if(!this.editModel.id) {
                    return
                }
                let params = _.merge(this.editModel);
                 this.form = new Form(params);
                this.loadingEdit = true;

                this.form.post(this.getRouteEditDepartment())
                    .then((response) => {
                        this.loadingEdit = false;
                        this.$notify({
                            type: 'success',
                            message: response.message,
                        });

                        this.showEditDepartment = false;

                        this.getDepartmentList({})
                    })
                    .catch((error) => {

                        this.loadingEdit = false;
                        this.$notify.error({
                            title: this.$t('mon.error.Title'),
                            message: this.getSubmitError(this.form.errors),
                        });
                    });
            },
            onFilterUser(filter_data) {
                this.queryServer(filter_data)
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

               window.axios.get(route('api.users.index', _.merge(properties, customProperties)))
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
            },
            getRouteCreateDepartment() {
                return route('api.department.store');
            },

            getRouteEditDepartment() {
                return  route('api.department.update', {department: this.editModel.id});
            },


        },
        mounted() {
            this.fetchData();
            this.getDepartmentList({});

        },
        created() {


        }
    }
</script>

<style scoped>
    .disabled {
        pointer-events:none;

    }

</style>
