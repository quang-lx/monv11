<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('box.label.title') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row  mb-2">
                    <div class="col-md-12 d-flex justify-content-end align-items-center">
                        <router-link :to="{ name: 'admin.box.create' }" class="f-action ">
                            <i class="el-icon-plus"></i>

                            Thêm mới

                        </router-link>

                        <span class="f-action pl-4 f-pointer" >
                            <inline-svg src="/images/download.svg" /> Tải xuống

                        </span>

                        <span class="f-action pl-4 f-pointer" @click="show_import = true">
                            <inline-svg src="/images/upload.svg" /> Tải lên

                        </span>





                        <el-input suffix-icon="el-icon-search" @keyup.native="performSearch" placeholder="Tìm kiếm" style="max-width: 300px" class="ml-3"
                            size="medium" v-model="searchQuery">
                        </el-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header ui-sortable-handle" style="cursor: move;">
                                <h3 class="card-title">
                                    {{ $t('box_area.label.title') }}
                                </h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <i class="el-icon-plus" style="cursor:pointer"
                                                @click="showArea = true"></i>
                                            <i class="el-icon-edit" v-bind:class="{ disabled: !parent_selected }"
                                                style="cursor:pointer" @click="showEditArea = true"></i>

                                            <i class="el-icon-delete" v-bind:class="{ disabled: !parent_selected }"
                                                style="cursor:pointer" @click="confirmDeleteArea"></i>
                                        </li>

                                    </ul>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <el-input class="mb-2" placeholder="Tìm kiếm"
                                    size="mini" v-model="filterArea">
                                </el-input>

                                <div class="mb-2">
                                    <span class="custom-tree-node" style="cursor:pointer" >
                                        <span> <inline-svg src="/images/d_all.svg" /> <span class="ml-2"> Tất cả
                                            </span></span>
                                        <span>{{ assign }}</span>
                                    </span>
                                </div>
                                <el-tree class="filter-tree" :data="areaTreeData" :props="treeProps"
                                         v-click-outside="removeNodeClick"
                                    default-expand-all :filter-node-method="filterNode" @node-click="handleNodeClick"
                                    ref="tree">
                                    <span class="custom-tree-node" slot-scope="{ node, data }">
                                        <span>{{ node.label }}</span>
                                        <span>{{ data.count_box }}</span>
                                    </span>
                                </el-tree>
                                <div class="mt-2 mb-2">
                                    <span class="custom-tree-node">
                                        <span class="ml-2"> Chưa xếp nhóm </span>
                                        <span>{{ not_assign }}</span>
                                    </span>
                                </div>
                                <el-tree class="filter-tree" :data="areaNotAssignTreeData" :props="treeProps"
                                         default-expand-all :filter-node-method="filterNode" @node-click="handleNotAssignNodeClick"
                                         ref="tree_not_assign">
                                    <span class="custom-tree-node" slot-scope="{ node, data }">
                                        <span>{{ node.label }}</span>
                                        <span>{{ data.count_box }}</span>
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

                                        <el-table-column prop="code" :label="$t('box.label.code')"  >

                                        </el-table-column>
                                        <el-table-column prop="name" :label="$t('box.label.name')"  >

                                        </el-table-column>
                                        <el-table-column prop="status" :label="$t('box.label.status')" sortable="status">
                                            <template slot-scope="scope">
                                                 <span >{{
                                                    scope.row.status_text }}</span>
                                            </template>

                                        </el-table-column>

                                        <el-table-column prop="actions" :label="$t('common.action')" width="100"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <edit-button
                                                    :to="{ name: 'admin.box.edit', params: { boxId: scope.row.id } }"></edit-button>
                                                <reload-delete-button :scope="scope"
                                                    message-confirm="Các thông tin này sẽ bị xóa và không thể hoàn tác."
                                                    title="XÓA BOX?" :rows="data"
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

        <el-dialog :close-on-click-modal="false" width="30%" :title="$t('box_area.label.add area')"
            :destroy-on-close="true" :visible.sync="showArea" :before-close="onClosePopup">


            <el-form ref="addDepartmentForm" :model="addModel" label-position="top" v-loading.body="loadingAdd">
                <el-form-item label="" :class="{ 'el-form-item is-error': form.errors.has('name') }">
                    <el-input maxlength="255" v-model="addModel.name" size="medium"></el-input>
                    <div class="el-form-item__error" v-if="form.errors.has('name')" v-text="form.errors.first('name')">
                    </div>

                </el-form-item>

            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small" @click="onClosePopup">{{ $t('common.cancel') }}</el-button>
                <el-button size="small" type="primary" @click="confirmAddArea">{{ $t('common.add') }}</el-button>
            </div>
        </el-dialog>
        <el-dialog :close-on-click-modal="false" width="30%" :show-close="false"
            :title="$t('box_area.label.edit area')" :destroy-on-close="true" :visible.sync="showEditArea">


            <el-form ref="addDepartmentForm" :model="editModel" label-position="top" v-loading.body="loadingEdit">
                <el-form-item label="" :class="{ 'el-form-item is-error': form.errors.has('name') }">
                    <el-input maxlength="255" v-model="editModel.name" size="medium"></el-input>
                    <div class="el-form-item__error" v-if="form.errors.has('name')" v-text="form.errors.first('name')">
                    </div>
                </el-form-item>

            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small" @click="showEditArea = false">{{ $t('common.cancel') }}</el-button>
                <el-button size="small" type="primary" @click="confirmEditArea">Sửa</el-button>
            </div>
        </el-dialog>


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
            form: new Form(),
            multipleSelection: [],

            list_selected_col: [],
            searchArea: '',


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
            showArea: false,
            showEditArea: false,
            columnsSearch: [],
            areaTreeData: [],
            areaNotAssignTreeData: [],
            areaLoading: false,
            filterArea: '',
            listFilterColumn: [],
            filter_data: {},
            file: '',
            loadingImport: 0,
            data_export: [],
            not_assign: 0,
            assign: 0,
            selected_area_id: null

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
        removeNodeClick() {
            // this.parent_selected = null
            // this.editModel.id = null
            // this.editModel.name = null
            // this.selected_department_id = null
            // this.queryServer({});

        },
        handleNodeClick(data, checked, indeterminate) {
            this.parent_selected = data.id
            this.editModel.id = data.id
            this.editModel.name = data.label

            let tree_node = this.$refs.tree.getCurrentNode()
            if (tree_node) {
                this.selected_area_id = tree_node.id
            }

            this.queryServer({});

        },
        handleNotAssignNodeClick(data, checked, indeterminate) {

            let tree_not_assign_node = this.$refs.tree_not_assign.getCurrentNode()
            if(tree_not_assign_node) {
                this.selected_area_id = tree_not_assign_node.id
            }
            this.queryServer({});

        },
        confirmDeleteArea() {
            if (this.parent_selected) {
                this.$confirm('Bạn có chắc chắn xóa nhóm này”', 'Xoá khu vực?', {
                    confirmButtonText: 'Xoá',
                    cancelButtonText: 'Ở lại',
                    type: 'warning'
                }).then(() => {
                    this.deleteArea()

                }).catch(() => {

                });
            }
        },
        deleteArea() {
            window.axios.delete(route('api.boxarea.destroy', { department: this.parent_selected }))
                .then((response) => {
                    if (response.data.errors === false) {
                        this.$notify({
                            type: 'success',
                            message: response.data.message,
                        });
                        this.getAreaList({})
                        this.getAreaNotAssign()

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
        confirmAddArea() {

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
                    this.showArea = false;
                    this.addModel.name = '';

                    this.getAreaList({})
                })
                .catch((error) => {

                    this.loadingAdd = false;
                    // this.$notify.error({
                    //     title: this.$t('mon.error.Title'),
                    //     message: this.getSubmitError(this.form.errors),
                    // });
                });
        },
        confirmEditArea() {
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

                    this.showEditArea = false;

                    this.getAreaList({})
                })
                .catch((error) => {

                    this.loadingEdit = false;
                    // this.$notify.error({
                    //     title: this.$t('mon.error.Title'),
                    //     message: this.getSubmitError(this.form.errors),
                    // });
                });
        },

        queryServer(customProperties) {


            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                area_id: this.selected_area_id,
                type: 1
            };


            window.axios.get(route('api.box.index', _.merge(_.merge(properties, customProperties),this.filter_data)))
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
        getAreaList(customProperties) {

            const properties = {

            };
            this.areaLoading = true;
            window.axios.get(route('api.boxarea.tree', _.merge(properties, customProperties)))
                .then((response) => {
                    this.areaLoading = false;
                    this.areaTreeData = response.data;

                });
        },
        getAreaNotAssignList(customProperties) {

            const properties = {

            };
            this.areaLoading = true;
            window.axios.get(route('api.boxarea.getNotAssignTree', _.merge(properties, customProperties)))
                .then((response) => {
                    this.areaLoading = false;
                    this.areaNotAssignTreeData = response.data;

                });
        },
        filterNode(value, data) {
            if (!value) return true;
            return data.label.indexOf(value) !== -1;
        },
        getRouteCreateDepartment() {
            return route('api.boxarea.store');
        },

        getRouteEditDepartment() {
            return route('api.boxarea.update', { boxarea: this.editModel.id });
        },
        getAreaTotal() {

            window.axios.get(route('api.boxarea.count', {}))
                .then((response) => {

                    this.not_assign = response.data.not_assign;
                    this.assign = response.data.assign;

                });
        },



        onClosePopup() {
            this.showArea = false
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
        this.getAreaList({});
        this.getAreaNotAssignList({});
        this.getAreaTotal();
        // document.addEventListener('click', this.handleDocumentClick);


    },

    beforeDestroy() {
        // Remove the click event listener when the component is destroyed
        // document.removeEventListener('click', this.handleDocumentClick);
    },
    watch: {
        filterArea(val) {
            this.$refs.tree.filter(val);
            this.$refs.tree_not_assign.filter(val);
        }
    },
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
