<template>
     <i class="el-icon-delete" @click="deleteRow" style = "cursor:pointer; padding-left: 8px"></i>

</template>

<script>
    export default {
        props: {
            rows: { default: null },
            scope: { default: null },
            title: {default: null},
            message: {default: null},
            confirmBtn:  {default: null},
            cancelBtn:  {default: null},
        },
        data() {
            return {
                deleteMessage: '',
                deleteTitle: '',
            };
        },
        methods: {
            deleteRow(event) {
                this.$confirm(this.deleteMessage, this.deleteTitle, {
                    confirmButtonText: this.confirmBtn? this.confirmBtn:  this.$t('mon.button.deleteBtn'),
                    cancelButtonText:this.cancelBtn? this.cancelBtn:  this.$t('mon.button.cancelBtn'),
                    type: 'warning',
                    confirmButtonClass: 'el-button--danger',
                }).then(() => {
                    const vm = this;
                   window.axios.delete(this.scope.row.urls.delete_url)
                        .then((response) => {
                            if (response.data.errors === false) {
                                vm.$message({
                                    type: 'success',
                                    message: response.data.message,
                                });

                                vm.rows.splice(vm.scope.$index, 1);
                            }else {
                                vm.$message({
                                    type: 'error',
                                    message: response.data.message,
                                });
                            }
                        })
                        .catch((error) => {
                            vm.$message({
                                type: 'error',
                                message: error.data.message,
                            });
                        });
                }).catch(() => {

                });
            },
        },
        mounted() {
            this.deleteMessage = this.message? this.message: this.$t('mon.modal.confirmation-message');
            this.deleteTitle = this.title? this.title: this.$t('mon.modal.title');
        },
    };
</script>
