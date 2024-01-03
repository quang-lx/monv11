<template>
    <div>
        <div class="content-header">
            <div class="row ">
                <div class="col-12">
                    <span class="f-breadcrumb">{{ $t('examinationservice.label.title') }}</span>
                    <hr>

                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-8   ">


                        <span class="f-action pl-4 f-pointer" @click="show_filter = true">
                            <inline-svg src="/images/filter.svg" /> Bộ lọc

                        </span>
                        <span class="f-action pl-4 f-pointer" :style="{ color: '#4B67E2 !important' }" @click="show_config = true">
                            <inline-svg  src="/images/list_blue.svg" /> Tuỳ chỉnh

                        </span>



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
                                        v-loading.body="tableIsLoading" @sort-change="handleSortChange"
                                        @selection-change="handleSelectionChange">
                                        <el-table-column :label="$t('disease.label.stt')" type="index" width="100"></el-table-column>
                                        <el-table-column v-for="col_selected in list_selected_col"
                                            :key="col_selected.col_name" :prop="col_selected.col_name"
                                            :label="list_col_label[col_selected.col_name]" min-width="150">
                                            <template slot-scope="scope">
                                                    <span v-if="col_selected.col_name == 'patient.sex'">{{
                                                        scope.row.patient.sex_text }}</span>
                                                <span v-if="col_selected.col_name == 'from_source'">{{
                                                        scope.row.source_text }}</span>
                                                    <span v-else-if="col_selected.col_name == 'status'"   :style="{ color: scope.row.status_color }">{{
                                                        scope.row.status_text }}</span>
                                                    <span v-else> {{getObjetValue(scope.row, col_selected.col_name)  }}</span>
                                            </template>


                                        </el-table-column>


                                        <el-table-column prop="actions" :label="$t('common.action')" width="150"
                                            fixed="right">
                                            <template slot-scope="scope">
                                                <i @click="onDowloadPDF(scope.row.id, scope.$index)" role="button" class=" mr-2" v-if="scope.row.status == 3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M11.8335 15.9909C11.8535 16.0165 11.8791 16.0373 11.9084 16.0515C11.9376 16.0657 11.9697 16.0731 12.0022 16.0731C12.0348 16.0731 12.0669 16.0657 12.0961 16.0515C12.1253 16.0373 12.1509 16.0165 12.171 15.9909L15.171 12.1954C15.2808 12.0561 15.1817 11.8499 15.0022 11.8499H13.0174V2.78557C13.0174 2.66772 12.921 2.57129 12.8031 2.57129H11.196C11.0781 2.57129 10.9817 2.66772 10.9817 2.78557V11.8472H9.00223C8.82277 11.8472 8.72366 12.0534 8.83348 12.1927L11.8335 15.9909ZM21.8058 15.0534H20.1987C20.0808 15.0534 19.9844 15.1499 19.9844 15.2677V19.3927H4.02009V15.2677C4.02009 15.1499 3.92366 15.0534 3.8058 15.0534H2.19866C2.0808 15.0534 1.98438 15.1499 1.98438 15.2677V20.5713C1.98438 21.0454 2.36741 21.4284 2.84152 21.4284H21.1629C21.6371 21.4284 22.0201 21.0454 22.0201 20.5713V15.2677C22.0201 15.1499 21.9237 15.0534 21.8058 15.0534Z" fill="black"/>
                                                    </svg>
                                                </i>
                                                <i disabled role="button" class=" mr-2" v-else>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <g opacity="0.5">
                                                            <path d="M11.8335 15.9909C11.8535 16.0165 11.8791 16.0373 11.9084 16.0515C11.9376 16.0657 11.9697 16.0731 12.0022 16.0731C12.0348 16.0731 12.0669 16.0657 12.0961 16.0515C12.1253 16.0373 12.1509 16.0165 12.171 15.9909L15.171 12.1954C15.2808 12.0561 15.1817 11.8499 15.0022 11.8499H13.0174V2.78557C13.0174 2.66772 12.921 2.57129 12.8031 2.57129H11.196C11.0781 2.57129 10.9817 2.66772 10.9817 2.78557V11.8472H9.00223C8.82277 11.8472 8.72366 12.0534 8.83348 12.1927L11.8335 15.9909ZM21.8058 15.0534H20.1987C20.0808 15.0534 19.9844 15.1499 19.9844 15.2677V19.3927H4.02009V15.2677C4.02009 15.1499 3.92366 15.0534 3.8058 15.0534H2.19866C2.0808 15.0534 1.98438 15.1499 1.98438 15.2677V20.5713C1.98438 21.0454 2.36741 21.4284 2.84152 21.4284H21.1629C21.6371 21.4284 22.0201 21.0454 22.0201 20.5713V15.2677C22.0201 15.1499 21.9237 15.0534 21.8058 15.0534Z" fill="black"/>
                                                        </g>
                                                    </svg>
                                                </i>
                                                <edit-button
                                                    :to="{ name: 'admin.examinationservice.edit', params: { examinationserviceId: scope.row.id } }"></edit-button>


                                                <reload-delete-button
                                                    v-if="scope.row.status == 1"
                                                    :scope="scope"
                                                    title-success="Xóa kết quả khám thành công"
                                                    title-error="Xóa kết quả khám thất bại"
                                                                      message-confirm="Kết quả khám sẽ bị xoá hoàn toàn khỏi hệ thống, bạn có chắc chắn xoá kết quả này?"
                                                                      title="Xoá kết quả khám" :rows="data"
                                                                      @delete-done="queryServer"></reload-delete-button>
                                                <i disabled role="button" class=" mr-2" style="opacity: 0.5;" v-else>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22" viewBox="0 0 19 22" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.74145 4.03415C4.66116 3.83171 6.58108 3.73047 8.50115 3.73047C11.7241 3.73047 14.9559 3.90176 18.1679 4.23412C18.5626 4.27497 18.8509 4.64224 18.8118 5.05443C18.7727 5.46663 18.4209 5.76766 18.0262 5.72681C14.86 5.39918 11.6755 5.23047 8.50115 5.23047C6.62919 5.23047 4.75709 5.32919 2.88477 5.52667L2.88266 5.52689L0.929012 5.72689C0.534224 5.76731 0.182809 5.46588 0.144104 5.05365C0.1054 4.64141 0.394062 4.27446 0.78885 4.23405L2.74145 4.03415Z" fill="black"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.04358 2.78456L6.83295 4.09421C6.76725 4.50271 6.39686 4.77824 6.00566 4.70964C5.61446 4.64104 5.35058 4.25428 5.41628 3.84578L5.62697 2.53579C5.63065 2.51297 5.63444 2.48908 5.63828 2.46487C5.70422 2.04899 5.80096 1.43887 6.19044 0.977691C6.64444 0.440117 7.33712 0.25 8.22192 0.25H10.731C11.6266 0.25 12.3186 0.455399 12.7699 0.998446C13.1599 1.46776 13.2542 2.08006 13.3172 2.48891C13.3202 2.5088 13.3232 2.52822 13.3262 2.54711L13.5365 3.84486C13.6027 4.25326 13.3393 4.64037 12.9482 4.70949C12.557 4.7786 12.1863 4.50355 12.1201 4.09514L11.9087 2.79069C11.8286 2.27767 11.7779 2.09352 11.6849 1.98155C11.6334 1.9196 11.4539 1.75 10.731 1.75H8.22192C7.48825 1.75 7.31424 1.91488 7.26785 1.96981C7.17964 2.07427 7.12985 2.24976 7.04358 2.78456Z" fill="black"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0878 7.39123C16.4836 7.41791 16.7838 7.77463 16.7583 8.18799L16.1355 18.2621L16.1342 18.2811C16.109 18.6573 16.0813 19.0711 16.007 19.456C15.93 19.8552 15.7943 20.2765 15.5194 20.6503C14.9437 21.433 13.9639 21.7497 12.5556 21.7497H6.40733C4.99901 21.7497 4.01925 21.433 3.44353 20.6503C3.16858 20.2765 3.03288 19.8552 2.95589 19.456C2.88165 19.0711 2.8539 18.6573 2.82867 18.2811L2.82712 18.258L2.20464 8.18799C2.17909 7.77463 2.47928 7.41791 2.87514 7.39123C3.271 7.36455 3.61262 7.67801 3.63817 8.09136L4.26039 18.1573C4.26043 18.1579 4.26048 18.1586 4.26053 18.1593C4.28755 18.5621 4.31043 18.8815 4.36413 19.1599C4.41642 19.431 4.48902 19.6091 4.58277 19.7366C4.74445 19.9564 5.14374 20.2497 6.40733 20.2497H12.5556C13.8192 20.2497 14.2185 19.9564 14.3801 19.7366C14.4739 19.6091 14.5465 19.431 14.5988 19.1599C14.6525 18.8815 14.6754 18.5621 14.7024 18.1593C14.7024 18.1586 14.7025 18.1579 14.7025 18.1573L15.3247 8.09136C15.3503 7.67801 15.6919 7.36455 16.0878 7.39123Z" fill="black"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.16406 15.5C7.16406 15.0858 7.48564 14.75 7.88232 14.75H11.0714C11.468 14.75 11.7896 15.0858 11.7896 15.5C11.7896 15.9142 11.468 16.25 11.0714 16.25H7.88232C7.48564 16.25 7.16406 15.9142 7.16406 15.5Z" fill="black"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.36719 11.5C6.36719 11.0858 6.68876 10.75 7.08544 10.75H11.8738C12.2705 10.75 12.5921 11.0858 12.5921 11.5C12.5921 11.9142 12.2705 12.25 11.8738 12.25H7.08544C6.68876 12.25 6.36719 11.9142 6.36719 11.5Z" fill="black"/>
                                                    </svg>
                                                </i>

                                                <i @click="onCancelService(scope.row.id, scope.$index)" role="button" class=" mr-2" v-if="scope.row.status == 2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                                        <path d="M19.267 5.71022C19.1745 5.61752 19.0646 5.54397 18.9436 5.49379C18.8227 5.44361 18.693 5.41778 18.562 5.41778C18.4311 5.41778 18.3014 5.44361 18.1804 5.49379C18.0594 5.54397 17.9495 5.61752 17.857 5.71022L12.967 10.5902L8.07702 5.70022C7.98444 5.60764 7.87453 5.5342 7.75356 5.4841C7.6326 5.43399 7.50295 5.4082 7.37202 5.4082C7.24109 5.4082 7.11144 5.43399 6.99048 5.4841C6.86951 5.5342 6.7596 5.60764 6.66702 5.70022C6.57444 5.79281 6.501 5.90272 6.45089 6.02368C6.40079 6.14464 6.375 6.27429 6.375 6.40522C6.375 6.53615 6.40079 6.6658 6.45089 6.78677C6.501 6.90773 6.57444 7.01764 6.66702 7.11022L11.557 12.0002L6.66702 16.8902C6.57444 16.9828 6.501 17.0927 6.45089 17.2137C6.40079 17.3346 6.375 17.4643 6.375 17.5952C6.375 17.7262 6.40079 17.8558 6.45089 17.9768C6.501 18.0977 6.57444 18.2076 6.66702 18.3002C6.7596 18.3928 6.86951 18.4662 6.99048 18.5163C7.11144 18.5665 7.24109 18.5922 7.37202 18.5922C7.50295 18.5922 7.6326 18.5665 7.75356 18.5163C7.87453 18.4662 7.98444 18.3928 8.07702 18.3002L12.967 13.4102L17.857 18.3002C17.9496 18.3928 18.0595 18.4662 18.1805 18.5163C18.3014 18.5665 18.4311 18.5922 18.562 18.5922C18.693 18.5922 18.8226 18.5665 18.9436 18.5163C19.0645 18.4662 19.1744 18.3928 19.267 18.3002C19.3596 18.2076 19.433 18.0977 19.4831 17.9768C19.5333 17.8558 19.559 17.7262 19.559 17.5952C19.559 17.4643 19.5333 17.3346 19.4831 17.2137C19.433 17.0927 19.3596 16.9828 19.267 16.8902L14.377 12.0002L19.267 7.11022C19.647 6.73022 19.647 6.09022 19.267 5.71022Z" fill="#FF0707"/>
                                                    </svg>
                                                </i>
                                                <i disabled role="button" class=" mr-2" v-else>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                                        <g opacity="0.3">
                                                            <path d="M19.267 5.71022C19.1745 5.61752 19.0646 5.54397 18.9436 5.49379C18.8227 5.44361 18.693 5.41778 18.562 5.41778C18.4311 5.41778 18.3014 5.44361 18.1804 5.49379C18.0594 5.54397 17.9495 5.61752 17.857 5.71022L12.967 10.5902L8.07702 5.70022C7.98444 5.60764 7.87453 5.5342 7.75356 5.4841C7.6326 5.43399 7.50295 5.4082 7.37202 5.4082C7.24109 5.4082 7.11144 5.43399 6.99048 5.4841C6.86951 5.5342 6.7596 5.60764 6.66702 5.70022C6.57444 5.79281 6.501 5.90272 6.45089 6.02368C6.40079 6.14464 6.375 6.27429 6.375 6.40522C6.375 6.53615 6.40079 6.6658 6.45089 6.78677C6.501 6.90773 6.57444 7.01764 6.66702 7.11022L11.557 12.0002L6.66702 16.8902C6.57444 16.9828 6.501 17.0927 6.45089 17.2137C6.40079 17.3346 6.375 17.4643 6.375 17.5952C6.375 17.7262 6.40079 17.8558 6.45089 17.9768C6.501 18.0977 6.57444 18.2076 6.66702 18.3002C6.7596 18.3928 6.86951 18.4662 6.99048 18.5163C7.11144 18.5665 7.24109 18.5922 7.37202 18.5922C7.50295 18.5922 7.6326 18.5665 7.75356 18.5163C7.87453 18.4662 7.98444 18.3928 8.07702 18.3002L12.967 13.4102L17.857 18.3002C17.9496 18.3928 18.0595 18.4662 18.1805 18.5163C18.3014 18.5665 18.4311 18.5922 18.562 18.5922C18.693 18.5922 18.8226 18.5665 18.9436 18.5163C19.0645 18.4662 19.1744 18.3928 19.267 18.3002C19.3596 18.2076 19.433 18.0977 19.4831 17.9768C19.5333 17.8558 19.559 17.7262 19.559 17.5952C19.559 17.4643 19.5333 17.3346 19.4831 17.2137C19.433 17.0927 19.3596 16.9828 19.267 16.8902L14.377 12.0002L19.267 7.11022C19.647 6.73022 19.647 6.09022 19.267 5.71022Z" fill="#FF0707"/>
                                                        </g>
                                                    </svg>
                                                </i>

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


        <filter-form :show_filter="show_filter" @on-filter="onFilter" @close-popup="closeFilter"></filter-form>

        <config-display-component :list_all_col="full_col_name" table_name="examination_service" :show_config="show_config"
            @on-save-config="onSaveConfigDisplay" @close-popup="closeConfig"></config-display-component>

    </div>
</template>

<script>
import InlineSvg from 'vue-inline-svg';
import _ from 'lodash';
import Form from "form-backend-validation";
import FilterForm from './filter_form';
import PopupImport from '../utils/PopupImport';
import ConfigDisplayComponent from "../utils/ConfigDisplayComponent";

export default {
    components: {
        InlineSvg,
        FilterForm,
        PopupImport,
        ConfigDisplayComponent
    },
    computed: {
        isShowCol: function () {
            return this.list_selected_col.reduce(
                (obj, item) => Object.assign(obj, { [item.col_name]: 1 }), {});
        },

        list_col_label: function () {
            return this.convertArrayToObject(this.full_col_name, 'col_name', 'name')

        },

    },
    data() {
        return {
            list_selected_col: [],


            full_col_name: [

                {
                    col_name: 'id',
                    name: this.$t('patient.label.id'),

                },
                {
                    col_name: 'patient.name',
                    name: this.$t('patient.label.name'),

                },
                {
                    col_name: 'patient.sex',
                    name: this.$t('patient.label.sex'),

                },
                {
                    col_name: 'patient.birthday',
                    name: this.$t('patient.label.birthday'),

                },
                {
                    col_name: 'patient.phone',
                    name: this.$t('patient.label.phone'),

                },
                 
                {
                    col_name: 'code',
                    name: 'Số phiếu',

                },
                {
                    col_name: 'service.code',
                    name: this.$t('service.label.code'),

                },
                {
                    col_name: 'service.name',
                    name: this.$t('service.label.name'),

                },

                {
                    col_name: 'service.min_value',
                    name: this.$t('service.label.min_value'),

                },

                {
                    col_name: 'service.max_value',
                    name: this.$t('service.label.max_value'),

                },
                {
                    col_name: 'service.ref_value',
                    name: this.$t('service.label.ref_value'),

                },
                {
                    col_name: 'service.unit',
                    name: this.$t('service.label.unit'),

                },
{
                    col_name: 'service.male_min_value',
                    name: this.$t('service.label.male_min_value'),

                },{
                    col_name: 'service.male_max_value',
                    name: this.$t('service.label.male_max_value'),

                },
                {
                    col_name: 'service.female_min_value',
                    name: this.$t('service.label.female_min_value'),

                },{
                    col_name: 'service.female_max_value',
                    name: this.$t('service.label.female_max_value'),

                },


                {
                    col_name: 'created_at',
                    name: 'Thời gian chỉ định',

                },
                {
                    col_name: 'result_at',
                    name: 'Thời gian trả kết quả',

                },
                {
                    col_name: 'ket_qua',
                    name: 'Kết quả',

                },
                {
                    col_name: 'ket_luan',
                    name: 'Kết luận',

                },
                {
                    col_name: 'status',
                    name: 'Trạng thái kết quả',

                },

                {
                    col_name: 'created_by_name',
                    name: 'Người chỉ định',

                },
                {
                    col_name: 'result_by_info',
                    name: 'Người trả kết quả',

                },
                {
                    col_name: 'from_source',
                    name: 'Nguồn dữ liệu',

                },


            ],
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
            multipleSelection: [],
            filter_data: [],

        };
    },
    methods: {
        onDowloadPDF(id, idx) {

        },

        onCancelService(id, idx) {
            this.$confirm("Dịch vụ sẽ bị huỷ, bạn có chắc chắn huỷ dịch vụ này?", 'Huỷ dịch vụ', {
                confirmButtonText: "Huỷ",
                cancelButtonText:"Không",
                // type: 'warning',
                confirmButtonClass: 'el-button--primary',
            }).then(() => {

                window.axios.post(route('api.examinationservice.cancel',{examinationservice:id}))
                    .then((response) => {
                        if (response.data.errors === false) {
                            this.data[idx].status = response.data.model.status
                            this.data[idx].status_text = response.data.model.status_text
                            this.data[idx].status_color = response.data.model.status_color
                            this.$notify({
                                type: 'success',
                                title: "Huỷ thành công",
                                message: response.data.message,
                            });


                        }
                    })
                    .catch((error) => {

                        this.$notify({
                            type: 'error',
                            title: "Huỷ thất bại",
                            message: error.data.message,
                        });
                    })
            }).catch(() => {

            });
        },
        closeFilter() {
            this.show_filter = false;
        },

        onFilter(filter_data) {
            this.filter_data = filter_data;
            this.queryServer(filter_data)
        },

        handleSelectionChange(val) {
            this.multipleSelection = val;
        },
        onSaveConfigDisplay(config_data) {
            this.list_selected_col = config_data
        },
        closeConfig() {
            this.show_config = false;
        },
        queryServer(customProperties) {

            const properties = {
                page: this.meta.current_page,
                per_page: this.meta.per_page,
                order_by: this.order_meta.order_by,
                order: this.order_meta.order,
                search: this.searchQuery,

            };

            window.axios.get(route('api.examinationservice.index', _.merge(properties, customProperties)))
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
