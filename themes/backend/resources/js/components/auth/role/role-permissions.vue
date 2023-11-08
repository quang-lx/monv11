<template>

<div>
    <el-checkbox v-model="is_select_all" @change="handleCheckAllChange">{{$t('role.label.select all')}}</el-checkbox>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">{{$t('common.stt')}}</th>
            <th scope="col">{{$t('role.label.group name')}}</th>
            <th scope="col" class="text-center">{{$t('role.label.function')}}</th>

        </tr>
        </thead>
        <tbody>

        <tr  v-for="(group, index, stt) in groupPermissions" :key="'g-' + index">
            <td scope="row" style="padding:0.25rem !important">{{stt+1}}</td>
            <td style="padding:0.25rem !important">{{group[0]? group[0].group_name: ''}}</td>
            <td class=" d-flex flex-row" style="padding:0.25rem !important">
                <div class="  pr-5"  v-for="(permission, pIndex) in group" :key="'p-'+pIndex">
                    <label class="control-label text-center"  >{{permission.title}}</label><br>
                    <el-switch
                        v-model="permissions[permission.name]"
                        active-color="#4B67E2"
                        :active-value="1"
                        :inactive-value="0"
                        inactive-color="#C8E1FF">
                    </el-switch>

                </div>
            </td>
        </tr>
        </tbody>
    </table>


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

               window.axios.get(route('api.permissions.all-by-group', _.merge({}, customProperties)))
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
