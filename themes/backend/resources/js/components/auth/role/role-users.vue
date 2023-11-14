<template>
    <div>



                <div class="row justify-content-between mb-2">
                    <div class="col-md-6   ">
                       <h5> {{ $t('role.label.list users') }}</h5>
                    </div>
                    <div class="col-md-6">


                        <div class="float-sm-right d-flex flex-row f-action" @click="show_add_user_form = true" style="cursor:pointer">
                            <i class="el-icon-plus   mr-2"></i>

                            <span>{{ $t('common.add') }}</span>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">

                                <div class="sc-table">

                                    <el-table
                                            :data="currentUsers"
                                            stripe
                                            style="width: 100%"
                                            ref="dataTable"
                                            v-loading.body="tableIsLoading"
                                            @sort-change="handleSortChange">
                                        <el-table-column   :label="$t('common.stt')" width="75" type="index"
                                                            >
                                        </el-table-column>
                                        <el-table-column prop="username" :label="$t('user.label.username')"  > </el-table-column>
                                        <el-table-column prop="name" :label="$t('user.label.name')"  >

                                        </el-table-column>
                                        <el-table-column prop="email" :label="$t('user.label.email')"  >

                                        </el-table-column>

                                        <el-table-column prop="phone" :label="$t('user.label.phone')"  >

                                        </el-table-column>

                                        <el-table-column prop="actions"  :label="$t('common.action')"  width="100">
                                            <template slot-scope="scope">
                                                   <i class="el-icon-close" style="cursor:pointer" @click="confirmRemoveUser(scope.row.id)"></i>
                                            </template>
                                        </el-table-column>
                                    </el-table>


                                </div>

                    </div>
                </div>

        <el-dialog :title="$t('role.label.add user title')" :visible.sync="show_add_user_form">

            <el-select
                v-model="user_selecteds"
                multiple
                filterable
                remote
                reserve-keyword
                :placeholder="$t('common.search')"
                :remote-method="remoteMethod"
                :loading="loading">
                <el-option
                    v-for="item in options"
                    :key="item.id"
                    :label="item.name"
                    :value="item.id">
                </el-option>
            </el-select>

            <span slot="footer" class="dialog-footer">
                <el-button @click="show_add_user_form = false">{{$t('common.cancel')}}</el-button>
                <el-button type="primary" @click="confirmAddUsers">{{$t('common.add')}}</el-button>
              </span>
        </el-dialog>


    </div>
</template>

<script>


    export default {
        props: {
            current_role_id : {default: null}
        },
        data() {
            return {
                currentUsers: [],
                show_add_user_form: false,
                searchQuery: '',
                user_selecteds: [],
                options: [],
                loading: false,


            };
        },
        methods: {
            getUserSelected() {
                if (this.current_role_id) {
                    const properties = {
                        page: 1,
                        per_page: 9000,
                        role_id: this.current_role_id
                    };

                    window.axios.get(route('api.users.index',properties))
                        .then((response) => {

                            this.currentUsers = response.data.data;
                            this.$emit("update-users", this.currentUsers) ;
                        });
                }


            },
            confirmRemoveUser(user_id) {
                this.$confirm('Bạn có chắc chắn muốn xóa người dùng này?', 'Xoá người dùng', {
                    confirmButtonText: 'Xoá',
                    cancelButtonText: 'Huỷ',
                    type: 'warning'
                }).then(() => {
                    this.removeUser(user_id)
                    this.$message({
                        type: 'success',
                        title: 'Xóa người dùng thành công',
                        message: 'Người dùng đã được xóa thành công.'
                    });
                }).catch(() => {
                    this.$message({
                        type: 'error',
                        title: 'Xóa người dùng thất bại',
                        message: 'Đã xảy ra lỗi không mong muốn, vui lòng thử lại.'
                    });
                });
            },
            removeUser(user_id) {
                this.currentUsers.filter (item => {return item.id != user_id})
            },
            queryServer(customProperties) {

                const properties = {
                    page: 1,
                    per_page: 25,
                    search: this.searchQuery,
                    exclude_ids: this.currentUsers.map (item => {return item.id})
                };

               window.axios.get(route('api.users.index', _.merge(properties, customProperties)))
                    .then((response) => {

                        this.options = response.data.data;
                        this.loading = false;

                    });
            },
            remoteMethod(query) {
                if (query !== '') {
                    this.searchQuery = query;
                    this.loading = true;
                    this.queryServer({})
                } else {
                    this.options = [];
                }
            },

            confirmAddUsers() {
                this.currentUsers = this.currentUsers.concat(this.options.filter(item => {
                    return this.user_selecteds.includes(item.id)
                }));
                this.options = [];
                this.user_selecteds = [];
                this.show_add_user_form = false;
            }

        },
        watch: {
            currentUsers: function() {
                this.$emit("update-users", this.currentUsers) ;
            },
        },
        mounted() {
            this.getUserSelected();

        },

    }
</script>

<style scoped>

</style>
