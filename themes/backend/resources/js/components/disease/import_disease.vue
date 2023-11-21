<template>
    <div>
        <el-dialog width="40%" :show-close="true" :title="$t('device.label.import title')" :destroy-on-close="true"
            :visible.sync="show_import">
            <div class="body-dialog">
                <div class="">
                    <div>Bấm để tải file lên hệ thống (File tải tối đã 20mb)</div>
                    <div class="import">
                        <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" />
                        <div class="text-danger mt-2" v-if="data_export?.errors"
                            v-text="data_export?.message"></div>
                        <el-progress v-if="loadingImport" :percentage="loadingImport == 1 ? 30 : 100"></el-progress>
                        <div v-if="loadingImport == 2" class="my-3">
                            <span class="text-success">{{ data_export.total_success }}</span> / {{ data_export.total }} tải
                            lên thành công
                        </div>
                        <div v-if="data_export.total_success < data_export.total && loadingImport == 2">
                            <a target=”_blank” class="text-danger" :href="data_export.fileUrl">Tải file dữ liệu lỗi</a>
                        </div>
                    </div>
                </div>
                <div class="">
                    <ul>
                        <li class="content">Hệ thống sẽ so sánh dữ liệu mà bạn tải lên để thêm mới nhân viên vào hệ thống.
                            Điều này đồng nghĩa
                            với việc bạn phải chuẩn bị sẵn mẫu dữ liệu mà bạn muốn thêm mới.
                        </li>
                        <li>Tải mẫu dữ liệu ở đây:</li>
                    </ul>
                </div>
                <div class="">
                    <el-button round size="small" icon="el-icon-download">
                        <a target=”_blank”  href="/excel-template/Diseases_Template.xlsx">Dữ liệu mẫu</a>
                    </el-button>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <el-button size="small" @click="closePopup">{{
                    $t("common.cancel")
                }}</el-button>
                <el-button size="small" type="primary" @click="onImportDisease">{{
                    $t("common.upload")
                }}</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
export default {
    props: {
        show_import: { default: false },
        loadingImport: { default: 0 },
        data_export: { default: [] }
    },
    data() {
        return {
            show_popup: this.show_import,
            modelForm: {
                file: "",
            },
        };
    },
    methods: {
        onImportDisease() {
            this.$emit("on-import", this.modelForm.file);
        },

        handleFileUpload() {
            this.modelForm.file = this.$refs.file.files[0];
        },
    },
    watch: {},
    mounted() {
        // this.getListDevice();
    },
};
</script>

<style scoped>
.import {
    margin: 20px 0px;

}

ul .content {
    margin-bottom: 20px;
    word-break: break-word;
}

ul {
    padding-left: 13px;
    margin-bottom: 5px;
}

a {
    color: #252423;
    font-size: 14px;
    font-weight: 400;
    line-height: normal;
    text-decoration-line: underline;
}
</style>
