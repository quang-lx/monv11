<template>
     <i   @click="deleteRow" style = "cursor:pointer; padding-left: 8px">
         <svg xmlns="http://www.w3.org/2000/svg" width="19" height="22" viewBox="0 0 19 22" fill="none">
             <path fill-rule="evenodd" clip-rule="evenodd" d="M2.72583 4.03415C4.64553 3.83171 6.56546 3.73047 8.48553 3.73047C11.7085 3.73047 14.9403 3.90176 18.1522 4.23412C18.547 4.27497 18.8353 4.64224 18.7962 5.05443C18.757 5.46663 18.4053 5.76766 18.0106 5.72681C14.8444 5.39918 11.6598 5.23047 8.48553 5.23047C6.61357 5.23047 4.74147 5.32919 2.86914 5.52667L2.86704 5.52689L0.913387 5.72689C0.518599 5.76731 0.167184 5.46588 0.128479 5.05365C0.0897745 4.64141 0.378437 4.27446 0.773225 4.23405L2.72583 4.03415Z" fill="black"/>
             <path fill-rule="evenodd" clip-rule="evenodd" d="M7.02796 2.78456L6.81733 4.09421C6.75163 4.50271 6.38124 4.77824 5.99003 4.70964C5.59883 4.64104 5.33496 4.25428 5.40066 3.84578L5.61135 2.53579C5.61503 2.51297 5.61882 2.48908 5.62265 2.46487C5.68859 2.04899 5.78534 1.43887 6.17482 0.977691C6.62881 0.440117 7.3215 0.25 8.20629 0.25H10.7154C11.611 0.25 12.3029 0.455399 12.7542 0.998446C13.1443 1.46776 13.2386 2.08006 13.3016 2.48891C13.3046 2.5088 13.3076 2.52822 13.3106 2.54711L13.5209 3.84486C13.5871 4.25326 13.3237 4.64037 12.9325 4.70949C12.5414 4.7786 12.1707 4.50355 12.1045 4.09514L11.8931 2.79069C11.813 2.27767 11.7623 2.09352 11.6693 1.98155C11.6178 1.9196 11.4383 1.75 10.7154 1.75H8.20629C7.47262 1.75 7.29862 1.91488 7.25223 1.96981C7.16401 2.07427 7.11423 2.24976 7.02796 2.78456Z" fill="black"/>
             <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0682 7.39123C16.4641 7.41791 16.7643 7.77463 16.7387 8.18799L16.116 18.2621L16.1147 18.2811C16.0895 18.6573 16.0617 19.0711 15.9875 19.456C15.9105 19.8552 15.7748 20.2765 15.4999 20.6503C14.9241 21.433 13.9444 21.7497 12.5361 21.7497H6.3878C4.97948 21.7497 3.99972 21.433 3.424 20.6503C3.14905 20.2765 3.01335 19.8552 2.93636 19.456C2.86211 19.0711 2.83437 18.6573 2.80914 18.2811L2.80759 18.258L2.18511 8.18799C2.15956 7.77463 2.45975 7.41791 2.85561 7.39123C3.25146 7.36455 3.59308 7.67801 3.61864 8.09136L4.24086 18.1573C4.2409 18.1579 4.24095 18.1586 4.241 18.1593C4.26802 18.5621 4.2909 18.8815 4.34459 19.1599C4.39689 19.431 4.46949 19.6091 4.56324 19.7366C4.72492 19.9564 5.12421 20.2497 6.3878 20.2497H12.5361C13.7996 20.2497 14.1989 19.9564 14.3606 19.7366C14.4544 19.6091 14.527 19.431 14.5793 19.1599C14.633 18.8815 14.6558 18.5621 14.6829 18.1593C14.6829 18.1586 14.6829 18.1579 14.683 18.1573L15.3052 8.09136C15.3308 7.67801 15.6724 7.36455 16.0682 7.39123Z" fill="black"/>
             <path fill-rule="evenodd" clip-rule="evenodd" d="M7.14453 15.5C7.14453 15.0858 7.4661 14.75 7.86279 14.75H11.0518C11.4485 14.75 11.7701 15.0858 11.7701 15.5C11.7701 15.9142 11.4485 16.25 11.0518 16.25H7.86279C7.4661 16.25 7.14453 15.9142 7.14453 15.5Z" fill="black"/>
             <path fill-rule="evenodd" clip-rule="evenodd" d="M6.35156 11.5C6.35156 11.0858 6.67314 10.75 7.06982 10.75H11.8582C12.2549 10.75 12.5764 11.0858 12.5764 11.5C12.5764 11.9142 12.2549 12.25 11.8582 12.25H7.06982C6.67314 12.25 6.35156 11.9142 6.35156 11.5Z" fill="black"/>
         </svg>
     </i>

</template>

<script>
    export default {
        props: {
            rows: { default: null },
            scope: { default: null },
            messageConfirm: { default: null },
            title: {default: null},
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
                                this.$emit('delete-done')
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
            this.deleteMessage = this.messageConfirm? this.messageConfirm:this.$t('mon.modal.confirmation-message');
            this.deleteTitle = this.title? this.title: this.$t('mon.modal.title');
        },
    };
</script>
