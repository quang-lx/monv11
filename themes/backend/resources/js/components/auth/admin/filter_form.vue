<template>
    <div>

        <el-dialog
 :close-on-click-modal="false"
 width="40%" :title="$t('user.label.filter title')" :destroy-on-close="true"
            @close="closePopup" :visible.sync="show_popup">


            <el-form ref="filterForm" :model="search_data" label-position="top" v-loading.body="loadingFilterUser">
                <div class="row">
                    <div class="col-sm-6">
                        <el-form-item :label="$t('user.label.status')">
                            <el-select v-model="search_data.status" size="small"
                                :placeholder="$t('user.label.select status')" filterable style="width: 100% !important">
                                <el-option v-for="item in listStatus" :key="'sex' + item.value" :label="item.label"
                                    :value="item.value">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('user.label.sex')">
                            <el-select v-model="search_data.sex" size="small" :placeholder="$t('user.label.select sex')"
                                filterable style="width: 100% !important">
                                <el-option v-for="item in listSex" :key="'sex' + item.value" :label="item.label"
                                    :value="item.value">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('user.label.time range')" style="width: 100% !important;">
                            <el-date-picker style="width: 100% !important;" size="small" v-model="search_data.time_range"
                                type="daterange" value-format="yyyy-MM-dd" range-separator="-"
                                :start-placeholder="$t('user.label.from date')" :end-placeholder="$t('user.label.to date')">
                            </el-date-picker>
                        </el-form-item>
                    </div>
                    <div class="col-sm-6">
                        <el-form-item :label="$t('user.label.created by')">
                            <el-select v-model="search_data.created_by" size="small"
                                :placeholder="$t('user.label.select created by')" filterable style="width: 100% !important">
                                <el-option v-for="item in listUser" :key="'sex' + item.id" :label="item.name"
                                    :value="item.id">
                                </el-option>

                            </el-select>
                        </el-form-item>
                    </div>
                </div>


            </el-form>

            <div class="d-flex justify-content-end">
                <el-button size="small" @click="setDefault">{{ $t('common.default') }}</el-button>
                <el-button size="small" @click="closeResetPopup">{{ $t('common.cancel') }}</el-button>
                <el-button size="small" :disabled="!Object.keys(this.search_data).some(key => this.search_data[key] !== null)" type="primary" @click="onSearchUser">{{ $t('common.apply') }}</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>


export default {
    props: {
        show_filter: { default: false }
    },

    data() {
        return {
            show_popup: this.show_config,
            search_data: {
                status: null,
                created_by: null,
                sex: null,
                time_range: null
            },
            loadingFilterUser: false,
            listStatus: [
                {
                    value: 1,
                    label: 'Đang hoạt động'
                },
                {
                    value: 2,
                    label: 'Không hoạt động'
                }
            ],
            listSex: [

                {
                    value: 'male',
                    label: 'Nam'
                },
                {
                    value: 'female',
                    label: 'Nữ'
                }
            ],
            listUser: []

        };
    },
    methods: {
        onSearchUser() {
            this.$emit("on-filter", this.search_data);
        },

        closeResetPopup() {
            this.search_data = {
                status: '',
                created_by: '',
                sex: '',
                time_range: []
            }
            this.$emit("close-popup");

        },

        getListUser() {

            const properties = {
                page: 1,
                per_page: 9000

            };

            window.axios.get(route('api.users.index', properties))
                .then((response) => {

                    this.listUser = response.data.data;

                });
        },
        setDefault() {
            this.search_data = {
                status: '',
                created_by: '',
                sex: '',
                time_range: []
            }
        }

    },
    watch: {
        show_filter(new_value) {
            this.show_popup = new_value;
        }
    },
    mounted() {
        this.getListUser();

    },

}
</script>

<style scoped></style>
