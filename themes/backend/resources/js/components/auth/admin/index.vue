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
                    <div class="col-md-8   ">
                        <router-link :to="{ name: 'admin.admins.create' }" class="f-action ">
                            <i class="el-icon-plus"></i>

                            {{ $t('user.label.create_user') }}

                        </router-link>
                        <span class="f-action pl-4 f-pointer" @click="show_filter = true">
                            <inline-svg src="/images/filter.svg" /> Bộ lọc

                        </span>

                        <span class="f-action pl-4 f-pointer" @click="exportUsers">
                            <inline-svg src="/images/download.svg" /> Tải xuống

                        </span>

                        <span class="f-action pl-4 f-pointer" @click="show_import = true">
                            <inline-svg src="/images/upload.svg" /> Tải lên

                        </span>

                        <span class="f-action pl-4 f-pointer" :style="{ color: '#4B67E2 !important' }"
                            @click="show_config = true">
                            <inline-svg src="/images/list_blue.svg" /> Tuỳ chỉnh

                        </span>

                    </div>
                    <div class="col-md-4">

                        <el-input suffix-icon="el-icon-search" @keyup.native="performSearch" placeholder="Tìm kiếm"
                            size="medium" v-model="searchQuery">
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
                                            <i class="el-icon-plus" style="cursor:pointer"
                                                @click="showAddDepartment = true"></i>
                                            <i class="el-icon-edit" v-bind:class="{ disabled: !parent_selected }"
                                                style="cursor:pointer" @click="showEditDepartment = true"></i>

                                            <i class="el-icon-delete" v-bind:class="{ disabled: !parent_selected }"
                                                style="cursor:pointer" @click="confirmDeleteDepartment"></i>
                                        </li>

                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <el-input class="mb-2" placeholder="Tìm kiếm" @keyup.native="performSearchDepartment"
                                    size="mini" v-model="filterDepartment">
                                </el-input>

                                <div class="mb-2">
                                    <span class="custom-tree-node" style="cursor:pointer" @click="">
                                        <span> <inline-svg src="/images/d_all.svg" /> <span class="ml-2"> Tất cả
                                            </span></span>
                                        <span>{{ department_user_total }}</span>
                                    </span>
                                </div>
                                <el-tree class="filter-tree" :data="departmentTreeData" :props="treeProps"
                                    default-expand-all :filter-node-method="filterNode" @node-click="handleNodeClick"
                                    ref="tree">
                                    <span class="custom-tree-node" slot-scope="{ node, data }">
                                        <span>{{ node.label }}</span>
                                        <span>{{ data.count_user }}</span>
                                    </span>
                                </el-tree>
                                <div class="mt-2 mb-2">
                                    <span class="custom-tree-node">
                                        <span class="ml-2"> Chưa xếp nhóm </span>
                                        <span>{{ count_not_assign }}</span>
                                    </span>
                                </div>
                                <el-tree class="filter-tree" :data="departmentNotAssignTreeData" :props="treeProps"
                                         default-expand-all :filter-node-method="filterNode" @node-click="handleNodeClick"
                                         ref="tree_not_assign">
                                    <span class="custom-tree-node" slot-scope="{ node, data }">
                                        <span>{{ node.label }}</span>
                                        <span>{{ data.count_user }}</span>
                                    </span>
                                </el-tree>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">

                            <div class="card-body">
                                <div class="sc-table">

                                    <el-table :data="data" stripe style="width: 100%" ref="dataTable"
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange">
                                        <!-- <el-table-column type="selection" width="55">
                                        </el-table-column> -->
                                        <el-table-column v-for="(col_selected, index_col) in list_selected_col"
                                            :key="col_selected.col_name + index_col" :prop="col_selected.col_name"
                                            :label="list_col_label[col_selected.col_name]" min-width="150">
                                            <template slot-scope="scope">

                                                <span v-if="col_selected.col_name == 'sex'">{{ scope.row.sex_text }}</span>
                                                <span v-else-if="col_selected.col_name == 'status'">{{
                                                    scope.row.status_text }}</span>
                                                <span v-else-if="col_selected.col_name == 'created_by'">
                                                    {{ scope.row.created_by_name }}
                                                </span>
                                                <span v-else-if="col_selected.col_name == 'department_id'">
                                                    {{ scope.row.department_name }}
                                                </span>
                                                <span v-else> {{ scope.row[col_selected.col_name] }}</span>

                                            </template>


                                        </el-table-column>



                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <edit-button
                                                    :to="{ name: 'admin.admins.edit', params: { userId: scope.row.id } }"></edit-button>
                                                <reload-delete-button :scope="scope"
                                                    message-confirm="Các thông tin này sẽ bị xóa và không thể hoàn tác."
                                                    title="XÓA NHÂN VIÊN?" :rows="data"
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

        <el-dialog :close-on-click-modal="false" width="30%" :title="$t('department.label.add department')"
            :destroy-on-close="true" :visible.sync="showAddDepartment" :before-close="onClosePopup">


            <el-form ref="addDepartmentForm" :model="addModel" label-position="top" v-loading.body="loadingAdd">
                <el-form-item label="" :class="{ 'el-form-item is-error': form.errors.has('name') }">
                    <el-input maxlength="255" v-model="addModel.name" size="medium"></el-input>
                    <div class="el-form-item__error" v-if="form.errors.has('name')" v-text="form.errors.first('name')">
                    </div>

                </el-form-item>

            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small" @click="onClosePopup">{{ $t('common.cancel') }}</el-button>
                <el-button size="small" type="primary" @click="confirmAddDepartment">{{ $t('common.add') }}</el-button>
            </div>
        </el-dialog>
        <el-dialog :close-on-click-modal="false" width="30%" :show-close="false"
            :title="$t('department.label.edit department')" :destroy-on-close="true" :visible.sync="showEditDepartment">


            <el-form ref="addDepartmentForm" :model="editModel" label-position="top" v-loading.body="loadingEdit">
                <el-form-item label="" :class="{ 'el-form-item is-error': form.errors.has('name') }">
                    <el-input maxlength="255" v-model="editModel.name" size="medium"></el-input>
                    <div class="el-form-item__error" v-if="form.errors.has('name')" v-text="form.errors.first('name')">
                    </div>
                </el-form-item>

            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small" @click="showEditDepartment = false">{{ $t('common.cancel') }}</el-button>
                <el-button size="small" type="primary" @click="confirmEditDepartment">Sửa</el-button>
            </div>
        </el-dialog>
        <filter-form :show_filter="show_filter" @on-filter="onFilterUser" @close-popup="closeFilter"></filter-form>
        <popup-import :show_import="show_import" :loadingImport="loadingImport" @on-import="onImportUsers"
            @close-popup="closeImport" url_template="/excel-template/Staff_Template.xlsx"
            content="Hệ thống sẽ so sánh dữ liệu mà bạn tải lên để thêm mới nhân viên vào hệ thống."
            :data_export="data_export"></popup-import>

        <config-display-component :list_all_col="full_col_name" table_name="user" :show_config="show_config"
            @on-save-config="onSaveConfigDisplay" @close-popup="closeConfig"></config-display-component>

    </div>
</template>

<script>
import FilterForm from './filter_form';
import InlineSvg from 'vue-inline-svg';
import ConfigDisplayComponent from './../../utils/ConfigDisplayComponent';
import _ from 'lodash';
import Form from "form-backend-validation";
import PopupImport from '../../utils/PopupImport';

export default {
    components: {
        FilterForm,
        InlineSvg,
        ConfigDisplayComponent,
        PopupImport

    },
    computed: {
        isShowCol: function () {
            return this.isShowCol.reduce(
                (obj, item) => Object.assign(obj, { [item.col_name]: 1 }), {});
        },

        list_col_label: function () {
            return this.convertArrayToObject(this.full_col_name, 'col_name', 'name')

        },

    },
    data() {
        return {
            form: new Form(),
            multipleSelection: [],

            list_selected_col: [],
            searchDepartment: '',


            full_col_name: [

                {
                    col_name: 'username',
                    name: this.$t('user.label.username'),

                },
                {
                    col_name: 'name',
                    name: this.$t('user.label.name'),

                },
                {
                    col_name: 'email',
                    name: this.$t('user.label.email'),

                },
                {
                    col_name: 'phone',
                    name: this.$t('user.label.phone'),

                },
                {
                    col_name: 'sex',
                    name: this.$t('user.label.sex'),

                },
                {
                    col_name: 'birth_day',
                    name: this.$t('user.label.birth_day'),

                },
                {
                    col_name: 'identification',
                    name: this.$t('user.label.identification'),

                },
                {
                    col_name: 'created_at',
                    name: this.$t('user.label.created_at'),

                },
                {
                    col_name: 'status',
                    name: this.$t('user.label.status'),

                },
                {
                    col_name: 'created_by',
                    name: this.$t('user.label.created by'),

                },
                {
                    col_name: 'department_id',
                    name: this.$t('user.label.department_id'),

                }
            ],
            show_config: false,
            show_filter: false,
            show_import: false,
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
            departmentNotAssignTreeData: [],
            departmentLoading: false,
            filterDepartment: '',
            listFilterColumn: [],
            filter_data: {},
            file: '',
            loadingImport: 0,
            data_export: [],
            count_not_assign: 0,
            department_user_total: 0,
            selected_department_id: null

        };
    },
    methods: {

        closeFilter() {
            this.show_filter = false;
        },

        closeImport() {
            this.show_import = false;
            this.loadingImport = 0;
            this.data_export = []
        },
        closeConfig() {
            this.show_config = false;
        },
        handleNodeClick(data, checked, indeterminate) {
            this.parent_selected = data.id
            this.editModel.id = data.id
            this.editModel.name = data.label
            this.queryServer({});

        },
        confirmDeleteDepartment() {
            if (this.parent_selected) {
                this.$confirm('Thành viên trong nhóm sẽ chuyển về nhóm “Chưa xếp nhóm”', 'Bạn có chắc chắn xóa nhóm này?', {
                    confirmButtonText: 'Xoá',
                    cancelButtonText: 'Ở lại',
                    type: 'warning'
                }).then(() => {
                    this.deleteDepartment()

                }).catch(() => {

                });
            }
        },
        deleteDepartment() {
            window.axios.delete(route('api.department.destroy', { department: this.parent_selected }))
                .then((response) => {
                    if (response.data.errors === false) {
                        this.$notify({
                            type: 'success',
                            message: response.data.message,
                        });
                        this.getDepartmentList({})
                        this.getDepartmentNotAssign()

                        this.parent_selected = null
                        this.editModel.id = null
                        this.editModel.name = null

                    } else {
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
                    // this.$notify.error({
                    //     title: this.$t('mon.error.Title'),
                    //     message: this.getSubmitError(this.form.errors),
                    // });
                });
        },
        confirmEditDepartment() {
            if (!this.editModel.id) {
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
                    // this.$notify.error({
                    //     title: this.$t('mon.error.Title'),
                    //     message: this.getSubmitError(this.form.errors),
                    // });
                });
        },
        onFilterUser(filter_data) {
            this.filter_data = filter_data;
            this.queryServer(filter_data)
        },
        onSaveConfigDisplay(config_data) {
            // this.show_config = false;
            this.list_selected_col = config_data
        },
        queryServer(customProperties) {
            let tree_node = this.$refs.tree.getCurrentNode()
            console.log(tree_node)
            if (tree_node) {
                this.selected_department_id = tree_node.id
            }
            let tree_not_assign_node = this.$refs.tree_not_assign.getCurrentNode()
            if(tree_not_assign_node) {
                this.selected_department_id = tree_not_assign_node.id
            }

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                department_id: this.selected_department_id,
                type: 1
            };


            window.axios.get(route('api.users.index', _.merge(_.merge(properties, customProperties),this.filter_data)))
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
                    this.departmentLoading = false;
                    this.departmentTreeData = response.data;

                });
        },
        getDepartmentNotAssignList(customProperties) {

            const properties = {

            };
            this.departmentLoading = true;
            window.axios.get(route('api.department.getNotAssignTree', _.merge(properties, customProperties)))
                .then((response) => {
                    this.departmentLoading = false;
                    this.departmentNotAssignTreeData = response.data;

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
            return route('api.department.update', { department: this.editModel.id });
        },
        getDepartmentNotAssign() {

            window.axios.get(route('api.department.countNotAssign', {}))
                .then((response) => {

                    this.count_not_assign = response.data.user_not_assign;
                    this.department_user_total = response.data.user_assign;

                });
        },

        exportUsers() {

            const properties = {
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                type: 1
            };

            window.axios.post(route('api.users.exports'), {
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

        handleFileUpload() {
            this.file = this.$refs.file.files[0];
        },

        onImportUsers(file) {
            this.loadingImport = 1;
            let formData = new FormData();
            formData.append("file", file);
            axios
                .post(route('api.users.imports'), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.loadingImport = 2;
                    this.$notify({
                        title: 'Thành công',
                        message: response.data.message,
                        type: 'success'
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
        performSearchDepartment: _.debounce(function (query) {
            // this.tableIsLoading = true;
            this.getDepartmentList({ search: query.target.value });
            this.getDepartmentNotAssignList({ search: query.target.value });
        }, 300),

        handleSelectionChange(val) {
            this.multipleSelection = val;
        },

        onClosePopup() {
            this.showAddDepartment = false
            this.addModel.name = null
            this.form = new Form()
        },

        handleDocumentClick(event) {
            // Check if the clicked element is outside the el-tree component
            const treeElement = this.$refs.tree.$el;
            console.log(event.target.class)
            let classTarget = event.target.classList.value;

            if (!treeElement.contains(event.target) && !['el-icon-plus', 'el-icon-edit', 'el-icon-delete'].find((element) => element == classTarget)) {
                this.parent_selected = null
                this.editModel.id = null
                this.editModel.name = null
            }
        },

    },
    mounted() {
        this.fetchData();
        this.getDepartmentList({});
        this.getDepartmentNotAssignList({});
        this.getDepartmentNotAssign();
        // document.addEventListener('click', this.handleDocumentClick);


    },

    beforeDestroy() {
        // Remove the click event listener when the component is destroyed
        // document.removeEventListener('click', this.handleDocumentClick);
    },
    created() {


    }
}
</script>

<style scoped>
.disabled {
    pointer-events: none;

}

.custom-tree-node {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: space-between;

}
</style>
