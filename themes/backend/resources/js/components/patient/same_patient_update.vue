<template>
    <div>

        <el-dialog
 :close-on-click-modal="false"
 width="40%" :show-close="false" :title="$t('patient.label.same patient')" :destroy-on-close="true"
            :visible.sync="show_same_patient">

            <div class="row">
                <div class="col-12">
                    Bệnh nhân có số điện thoại trùng với bệnh nhân cũ, bạn có muốn chọn bệnh nhân Tái khám?
                </div>
            </div>
            <div class="row my-2 ml-3">
                <div class="col-12" v-for="patient in list_patient_same">
                    <div>{{ patient.id }} {{ patient.name }} - {{ new
                        Date(patient.birthday).toLocaleDateString('en-GB').replace(/\//g, '/') }}
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-end">
                <el-button size="small" @click="onCancel">{{ $t('common.cancel') }}</el-button>
                <el-button size="small" type="primary" @click="onUpdatePatient">{{ $t('common.update') }}</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>


export default {
    props: {
        show_same_patient: { default: false },
        list_patient_same: { default: [] }
    },
    data() {
        return {
            show_popup: this.show_same_patient,
            loadingFilterPatient: false,
            patient_select: null,
        };
    },
    methods: {
        onCancel() {
            this.show_popup = false;
            this.$emit("close-popup", true);
        },
        onUpdatePatient() {
            this.$emit("on-update", true);
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

    },


}
</script>

<style scoped>
.el-radio {
    color: var(--common-4, #252525) !important;
    font-size: 14px !important;
    font-weight: 400 !important;
    line-height: 22px !important;
}
</style>
