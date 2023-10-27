<template>

<div>
    <div class="row bg-light mb-2"  v-for="(group, index) in groupPermissions" :key="'g-' + index" >
        <div class="col-md-3 d-flex align-items-center">{{group[0]? group[0].group_name: ''}}</div>
        <div class="col-md-9 d-flex flex-row">
            <div class="  p-2  pr-5"  v-for="(permission, pIndex) in group" :key="'p-'+pIndex">
                <label class="control-label text-center"  >{{permission.title}}</label><br>
                <el-switch
                    v-model="permissions[permission.name]"
                    active-color="#13ce66"
                    :active-value="1"
                    :inactive-value="0"
                    inactive-color="#ff4949">
                </el-switch>

            </div>


        </div>
    </div>

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
                permissions: {}

            };
        },
        methods: {
            queryServer(customProperties) {

                const properties = {
                    role_id: this.roleId,
                    guard_name: this.guard_name,
                    in_role: (this.type === 'add')? 0: 1
                };

                axios.get(route('api.permissions.all-by-group', _.merge({}, customProperties)))
                    .then((response) => {

                        this.groupPermissions = response.data;

                    });
            },
            fetchData() {
                this.tableIsLoading = true;
                this.queryServer({});
            },
            changeState(group, state) {
                _.forEach(group, (permission, key) => {
                    this.permissions[permission.name] = state;
                });
            },
            triggerEvent(permission_name, state) {
                this.$emit('input', this.permissions);
            }


        },
        watch: {
            currentPermissions() {
                if (this.currentPermissions !== null) {
                    this.permissions = this.currentPermissions;
                }
            },
        },
        mounted() {
            this.fetchData();

        },
    }
</script>

<style scoped>

</style>
