<template>
    <div>



        <div class="row justify-content-between mb-2">
            <div class="col-md-4 d-flex flex-row align-items-center">
                <span>Danh sách chỉ số con</span>
                <el-input suffix-icon="el-icon-search" @keyup.native="performSearch" placeholder="Tìm kiếm chỉ số"
                    size="small" v-model="searchQuery">
                </el-input>
            </div>
            <div class="col-md-8 d-flex flex-row align-items-center d-flex justify-content-end">

                <span class="f-action pl-4 f-pointer" @click="addItem">
                    <inline-svg src="/images/add.svg" /> {{ $t('common.add') }}

                </span>


                <span class="f-action pl-4 f-pointer">
                    <inline-svg src="/images/download.svg" /> Tải xuống

                </span>

                <span class="f-action pl-4 f-pointer">
                    <inline-svg src="/images/upload.svg" /> Tải lên

                </span>

                <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange"
                    :current-page.sync="meta.current_page" :page-sizes="[20, 40, 60, 80, 100]"
                    :page-size="parseInt(meta.per_page)" layout="sizes, prev, pager, next" :total="meta.total"
                    v-if="meta.total > 25">
                </el-pagination>

            </div>

        </div>

        <div class="row">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="sc-table">

                            <el-table :data="data" stripe style="width: 100%" ref="dataTable"
                                v-loading.body="tableIsLoading" @sort-change="handleSortChange">

                                <el-table-column :label="$t('common.stt')" width="75" :index="indexMethod" type="index">
                                </el-table-column>


                                <el-table-column prop="code" :label="$t('service.label.code')" width="120">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input maxlength="255" v-model="scope.row.code" size="small"
                                                placeholder="Nhập mã dịch vụ"></el-input>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.code }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="code" :label="$t('service.label.code_lis')" width="120">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input maxlength="255" v-model="scope.row.code_lis" size="small"
                                                placeholder="Nhập mã dịch vụ gửi LIS"></el-input>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.code_lis }}

                                        </span>
                                    </template>
                                </el-table-column>

                                <el-table-column prop="name" :label="$t('service.label.name')" min-width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input maxlength="255" v-model="scope.row.name" size="small"
                                                placeholder="Nhập tên dịch vụ"></el-input>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.name }}

                                        </span>
                                    </template>
                                </el-table-column>

                                <el-table-column prop="min_value" :label="$t('service.label.min_value')" width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.min_value" size="small"
                                                placeholder="Nhập giá trị thấp" style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.min_value }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="max_value" :label="$t('service.label.max_value')" width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.max_value" size="small"
                                                placeholder="Nhập giá trị cao" style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.max_value }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="ref_value" :label="$t('service.label.ref_value')" width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.ref_value" size="small"
                                                placeholder="Nhập giá trị cao" disabled style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.ref_value }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="unit" :label="$t('service.label.unit')" width="100">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input v-model="scope.row.unit" size="small" disabled
                                                autocomplete="off"></el-input>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.unit }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="male_min_value" :label="$t('service.label.male_min_value')"
                                    width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.male_min_value"
                                                size="small" placeholder="Nhập giá nam trị thấp" style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.male_min_value }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="male_max_value" :label="$t('service.label.male_max_value')"
                                    width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.male_max_value"
                                                size="small" placeholder="Nhập giá trị nam cao" style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.male_max_value }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="female_min_value" :label="$t('service.label.female_min_value')"
                                    width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.female_min_value"
                                                size="small" placeholder="Nhập giá trị nữ thấp" style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.female_min_value }}

                                        </span>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="female_max_value" :label="$t('service.label.female_max_value')"
                                    width="150">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <el-input-number :controls="false" v-model="scope.row.female_max_value"
                                                size="small" placeholder="Nhập giá trị nữ cao" style="width: 100%"
                                                autocomplete="off"></el-input-number>
                                        </span>
                                        <span v-else>
                                            {{ scope.row.female_max_value }}

                                        </span>
                                    </template>
                                </el-table-column>



                                <el-table-column prop="actions" :label="$t('common.action')" width="100" fixed="right">
                                    <template slot-scope="scope">
                                        <span v-if="scope.row.is_edit">
                                            <i @click="saveRow(scope.$index)" style="cursor:pointer">
                                                <svg width="19" height="22" viewBox="0 0 19 22" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.5 20H6.5V22H4.5V20ZM8.5 20H10.5V22H8.5V20ZM12.5 20H14.5V22H12.5V20ZM14.5 0H2.5C1.96957 0 1.46086 0.210714 1.08579 0.585786C0.710714 0.960859 0.5 1.46957 0.5 2V16C0.5 16.5304 0.710714 17.0391 1.08579 17.4142C1.46086 17.7893 1.96957 18 2.5 18H16.5C17.6 18 18.5 17.1 18.5 16V4L14.5 0ZM16.5 16H2.5V2H13.67L16.5 4.83V16ZM9.5 9C7.84 9 6.5 10.34 6.5 12C6.5 13.66 7.84 15 9.5 15C11.16 15 12.5 13.66 12.5 12C12.5 10.34 11.16 9 9.5 9ZM3.5 3H12.5V7H3.5V3Z"
                                                        fill="#6C757D" />
                                                </svg>

                                            </i>
                                            <i @click="discardRow(scope.$index)" style="cursor:pointer; padding-left: 8px">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M18.7983 5.70998C18.7058 5.61728 18.5959 5.54373 18.4749 5.49355C18.3539 5.44337 18.2242 5.41754 18.0933 5.41754C17.9623 5.41754 17.8326 5.44337 17.7116 5.49355C17.5907 5.54373 17.4808 5.61728 17.3883 5.70998L12.4983 10.59L7.60827 5.69998C7.51569 5.6074 7.40578 5.53396 7.28481 5.48385C7.16385 5.43375 7.0342 5.40796 6.90327 5.40796C6.77234 5.40796 6.64269 5.43375 6.52173 5.48385C6.40076 5.53396 6.29085 5.6074 6.19827 5.69998C6.10569 5.79256 6.03225 5.90247 5.98214 6.02344C5.93204 6.1444 5.90625 6.27405 5.90625 6.40498C5.90625 6.53591 5.93204 6.66556 5.98214 6.78652C6.03225 6.90749 6.10569 7.0174 6.19827 7.10998L11.0883 12L6.19827 16.89C6.10569 16.9826 6.03225 17.0925 5.98214 17.2134C5.93204 17.3344 5.90625 17.464 5.90625 17.595C5.90625 17.7259 5.93204 17.8556 5.98214 17.9765C6.03225 18.0975 6.10569 18.2074 6.19827 18.3C6.29085 18.3926 6.40076 18.466 6.52173 18.5161C6.64269 18.5662 6.77234 18.592 6.90327 18.592C7.0342 18.592 7.16385 18.5662 7.28481 18.5161C7.40578 18.466 7.51569 18.3926 7.60827 18.3L12.4983 13.41L17.3883 18.3C17.4809 18.3926 17.5908 18.466 17.7117 18.5161C17.8327 18.5662 17.9623 18.592 18.0933 18.592C18.2242 18.592 18.3538 18.5662 18.4748 18.5161C18.5958 18.466 18.7057 18.3926 18.7983 18.3C18.8909 18.2074 18.9643 18.0975 19.0144 17.9765C19.0645 17.8556 19.0903 17.7259 19.0903 17.595C19.0903 17.464 19.0645 17.3344 19.0144 17.2134C18.9643 17.0925 18.8909 16.9826 18.7983 16.89L13.9083 12L18.7983 7.10998C19.1783 6.72998 19.1783 6.08998 18.7983 5.70998Z"
                                                        fill="#FF0707" />
                                                </svg>

                                            </i>
                                        </span>
                                        <span v-else>
                                            <i class="el-icon-edit" @click="editRow(scope.$index)"
                                                style="cursor:pointer"></i>
                                            <i class="el-icon-delete" @click="deleteRow(scope.$index)"
                                                style="cursor:pointer; padding-left: 8px"></i>
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
        service_id: { default: null }
    },
    data() {
        return {
            old_data: [],

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
            row_default: {
                code: '',
                code_lis: '',
                name: '',
                type: '',
                min_value: undefined,
                max_value: undefined,
                ref_value: undefined,
                unit: '',
                male_min_value: undefined,
                male_max_value: undefined,
                female_min_value: undefined,
                female_max_value: undefined,
                is_edit: 1
            }

        };
    },
    methods: {
        saveRow(index) {
            let routeUri = route('api.serviceindex.store');
            const vm = this;
            if (this.data[index].id) {
                routeUri = route('api.serviceindex.update', { serviceindex: this.data[index].id });
            }
            const params = _.merge(this.data[index], { service_id: this.service_id })
            window.axios.post(routeUri, params)
                .then((response) => {
                    if (response.data.errors === false) {
                        vm.$notify({
                            type: 'success',
                            title: 'Thành công',
                            message: response.data.message,
                        });
                        this.data[index].id = response.data.id
                        this.data[index].is_edit = 0
                    } else {
                        vm.$notify({
                            type: 'error',
                            title: 'Thất bại',
                            message: this.getSubmitError(response.data.errors)
                        });
                    }
                })
                .catch((error) => {
console.log(error)
                    vm.$notify({
                        type: 'error',
                        title: 'Thất bại',
                        message: this.getSubmitError(error.response.data.errors)
                    });
                });
        },
        discardRow(index) {
            if (this.old_data[index]) {
                this.data.splice(index, 1, this.old_data[index])
            } else {
                this.data.splice(index, 1);
            }

        },
        editRow(index) {
            this.old_data[index] = _.cloneDeep(this.data[index])
            this.data[index].is_edit = 1
        },

        deleteRow(index) {

            this.$confirm("Các thông tin này sẽ bị xóa và không thể hoàn tác.", "XÓA CHỈ SỐ CON?", {
                confirmButtonText: this.confirmBtn ? this.confirmBtn : this.$t('mon.button.deleteBtn'),
                cancelButtonText: this.cancelBtn ? this.cancelBtn : this.$t('mon.button.cancelBtn'),
                type: 'warning',
                confirmButtonClass: 'el-button--danger',
            }).then(() => {
                if (!this.data[index].id) {
                    this.data.splice(index, 1);
                } else {
                    const vm = this;
                    let routeUri = route('api.serviceindex.destroy', { serviceindex: this.data[index].id });
                    window.axios.delete(routeUri)
                        .then((response) => {
                            if (response.data.errors === false) {

                                vm.$notify({
                                    type: 'success',
                                    title: 'Thành công',
                                    message: response.data.message,
                                });
                                this.data.splice(index, 1);

                            }
                        })
                        .catch((error) => {

                            this.$notify({
                                type: 'error',
                                title: 'Thất bại',
                                message: error.data.message,
                            });
                        });
                }

            }).catch(() => {

            });
        },
        addItem() {
            this.data.push(_.cloneDeep(this.row_default))

        },

        queryServer(customProperties) {

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,
                service_id: this.service_id
            };

            window.axios.get(route('api.serviceindex.index', _.merge(properties, customProperties)))
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

        indexMethod(index) {
            if (!this.tableIsLoading) {
                return index + (this.meta.current_page - 1) * this.meta.per_page + 1;
            }
        }


    },
    mounted() {
        if (this.service_id) {
            this.fetchData();
        }



    },
    watch: {
        data: function () {
            this.$emit("update-service-index", this.data);
        },
    },
}
</script>

<style scoped>
.disabled {
    pointer-events: none;

}</style>
