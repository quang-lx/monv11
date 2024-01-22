<template>
    <div>
        <el-dialog :close-on-click-modal="false" width="40%" :show-close="true" :title="$t('device.label.import title')"
            :destroy-on-close="true" :visible.sync="show_import" :before-close="onClosePopup">
            <div class="body-dialog">
                <div class="">
                    <div>Bấm để tải file lên hệ thống (File tải tối đa 20mb)</div>
                    <div class="import">
                        <div class="custom-file">
                            <input id="file" ref="file" v-on:change="handleFileUpload()" type="file"
                                class="custom-file-input">
                            <label :class="{ 'file-error': isEmpty }" class="custom-file-label" for="file">{{ file_name
                            }}</label>
                            <img src="/images/icon.svg" alt="">
                        </div>
                        <!-- <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" /> -->
                        <div class="text-danger mt-2" v-if="isEmpty">
                            Trường thông tin bắt buộc
                        </div>
                        <div  class="text-danger mt-2" v-if="data_export?.errors" v-text="data_export?.message"></div>
                        <el-progress class="mt-2" v-if="loadingImport"
                            :percentage="loadingImport == 1 ? 30 : 100"></el-progress>
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
                        <li class="content_import">
                            {{ content }}
                            <!-- Hệ thống sẽ so sánh dữ liệu mà bạn tải lên để thêm mới nhân viên vào hệ
                            thống. -->
                            Điều này đồng nghĩa
                            với việc bạn phải chuẩn bị sẵn mẫu dữ liệu mà bạn muốn thêm mới.
                        </li>
                        <li>Tải mẫu dữ liệu ở đây:</li>
                    </ul>
                </div>
                <div class="data_template">
                    <img src="/images/Paper Download.svg" alt="">
                    <a target=”_blank” :href="url_template">Dữ liệu mẫu</a>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <el-button size="small" @click="onClosePopup">{{
                    $t("common.cancel")
                }}</el-button>
                <el-button size="small" :disabled="loadingImport == 1" type="primary" @click="onImport">{{
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
        url_template: { default: 0 },
        data_export: { default: [] },
        content: { default: '' },
    },
    data() {
        return {
            file_name: '.xlsx',
            modelForm: {
                file: ''
            },
            isEmpty: false
        };
    },
    methods: {
        onImport() {
            if (!this.modelForm.file) {
                this.isEmpty = true;
                return
            }
            this.$emit("on-import", this.modelForm.file);
        },

        onClosePopup() {
            this.modelForm.file = '';
            this.file_name = '.xlsx'
            this.$refs.file.value = null
            this.$emit("close-popup");
            // this.data_export = []
        },

        handleFileUpload() {
            this.modelForm.file = this.$refs.file.files[0];
            this.file_name = this.$refs.file.files[0].name
        },
    },
    watch: {
        loadingImport: function () {
            if (this.loadingImport == 2) {
                this.modelForm.file = '';
                this.file_name = '.xlsx'
                this.$refs.file.value = null
            }
        },

        modelForm: {
            handler(val) {
                if (this.modelForm.file) {
                    this.isEmpty = false
                }
            },
            deep: true
        }
    },
    mounted() {
        // this.getListDevice();
    },
};
</script>

<style scoped>
.import {
    margin-bottom: 20px;
    margin-top: 5px;

}

ul .content_import {
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

.custom-file-label::after {
    content: none
}

.custom-file {
    position: relative;
}

.custom-file img {
    position: absolute;
    right: 10px;
    top: 6px;
    z-index: 10;
}

.custom-file-input {
    height: 40px;
    padding: 6px 12px;
    align-items: center;
    gap: 12px;
    align-self: stretch;
    border-radius: 4px;
    border: 1px solid var(--stroke-1, #E5E5EA);
    background: #FAFAFA;
}

.data_template {
    border-radius: 28px;
    border: 1px solid var(--icon-aeaeb-2, rgba(60, 60, 67, 0.30));
    background: rgba(248, 248, 248, 0.82);
    display: inline-flex;
    padding: 8px 20px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin-top: 10px;
}

.file-error {
    border: 1px solid red
}
</style>
