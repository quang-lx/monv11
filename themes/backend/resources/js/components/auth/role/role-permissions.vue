<template>

<div>
    <el-checkbox v-model="is_select_all" @change="handleCheckAllChange" class="mb-3">{{$t('role.label.select all')}}</el-checkbox>



    <el-table
        ref="permissionTable"
        :data="groupPermissions"
        style="width: 100%" >
        <el-table-column   :label="$t('common.stt')" width="75" type="index"
                            >

        </el-table-column>

        <el-table-column
            property="group_name"
            :label="$t('role.label.group name')">
            <template slot-scope="scope">
                <span>{{scope.row.group_name}}</span>
            </template>
        </el-table-column>
        <el-table-column
            width="100"
            :label="$t('role.label.function')"
        >
            <template slot-scope="scope">
                <div class="d-flex flex-row">
                    <div class="  pr-5"  v-for="(permission, pIndex) in scope.row.permissions" :key="'p-'+pIndex">
                        <label class="control-label text-center"  >{{permission.title}}</label><br>
                        <el-switch
                            v-model="permissions[permission.name]"
                            active-color="#4B67E2"
                            :active-value="1"
                            :inactive-value="0"
                            inactive-color="#C8E1FF">
                        </el-switch>

                    </div>
                </div>

            </template>
        </el-table-column>
    </el-table>


</div>

</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        props: {
            currentPermissions: { default: null },
        },
        data() {
            return {
                is_select_all: false,
                count_index: 0,
                groupPermissions: [],

                links: {},
                checkedPermissions:[],
                guards: [
                    {
                        value: 'api',
                        label: 'api'
                    },
                    {
                        value: 'web',
                        label: 'web'
                    }
                ],
                guard_name: '',
                permissions: this.currentPermissions

            };
        },
        methods: {
            handleCheckAllChange(val) {
                let checked = val? 1: 0;
                for (const [key, value] of Object.entries(this.permissions)) {
                    this.permissions[key] = checked
                }
            },
            queryServer(customProperties) {

                const properties = {
                    role_id: this.roleId,
                    guard_name: this.guard_name,
                    in_role: (this.type === 'add')? 0: 1
                };

               window.axios.get(route('api.permissions.all-by-group-array', _.merge({}, customProperties)))
                    .then((response) => {

                        this.groupPermissions = response.data;

                    });
            },
            fetchData() {
                this.tableIsLoading = true;
                this.queryServer({});
            },



        },
        watch: {
            permissions: function() {
                this.$emit("update-permissions", this.permissions) ;
            },
        },
        mounted() {
            this.fetchData();

        },
    }
</script>

<style scoped>

</style>
