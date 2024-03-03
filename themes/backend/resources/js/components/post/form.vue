<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="float-left d-flex align-items-center">
                            <i
                                class="el-icon-arrow-left f-icon-bound-breadcrumb mr-2"
                                @click="gotoPage({ name: 'admin.post.index' })"
                            ></i>
                            <span class="f-breadcrumb">{{
                                $t(pageTitle)
                            }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="float-right">
                            <el-button
                                class="btn btn-flat btn-cancel"
                                size="small"
                                @click="onCancel()"
                            >
                                {{ $t("mon.button.cancel") }}
                            </el-button>
                            <el-button
                                type="primary"
                                @click="onSubmit()"
                                size="small"
                                :loading="loading"
                                class="btn btn-flat btn-primary"
                            >
                                {{
                                    $route.params.postId
                                        ? $t("mon.button.update")
                                        : $t("mon.button.add")
                                }}
                            </el-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div
                                    class="f-box-title d-flex align-items-center"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="18"
                                        height="18"
                                        viewBox="0 0 18 18"
                                        fill="none"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M9.27621 16.4654C5.11252 16.4654 1.72519 13.0781 1.72519 8.91458C1.72519 4.7509 5.11252 1.36338 9.27621 1.36338C13.4399 1.36338 16.8272 4.7509 16.8272 8.91458C16.8272 13.0781 13.4399 16.4654 9.27621 16.4654ZM9.27621 0.431152C4.5985 0.431152 0.792969 4.23687 0.792969 8.91458C0.792969 13.5921 4.5985 17.3976 9.27621 17.3976C13.9539 17.3976 17.7595 13.5921 17.7595 8.91458C17.7595 4.23687 13.9539 0.431152 9.27621 0.431152Z"
                                            fill="#252525"
                                        />
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M9.08916 4.04907C8.67749 4.04907 8.34375 4.39083 8.34375 4.81256C8.34375 5.2343 8.67749 5.57606 9.08916 5.57606C9.50139 5.57606 9.83531 5.2343 9.83531 4.81256C9.83531 4.39083 9.50139 4.04907 9.08916 4.04907Z"
                                            fill="#252525"
                                        />
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M7.78516 8.07529H8.8106V13.9483H9.74283V7.14307H7.78516V8.07529Z"
                                            fill="#252525"
                                        />
                                    </svg>
                                    <span class="f-text-title pl-1">
                                        Thông tin chung</span
                                    >
                                </div>

                                <el-form
                                    :rules="formRules"
                                    ref="modelForm"
                                    :model="modelForm"
                                    label-position="top"
                                    v-loading.body="loading"
                                >
                                    <div class="row">
                                        <div class="col-md-4">
                                            <el-form-item
                                                :label="$t('post.label.name')"
                                                prop="name"
                                                :class="{
                                                    'el-form-item is-error':
                                                        form.errors.has('name'),
                                                }"
                                            >
                                                <el-input
                                                    maxlength="255"
                                                    v-model="modelForm.name"
                                                    size="small"
                                                    placeholder="Nhập tên thiết bị"
                                                ></el-input>
                                                <div
                                                    class="el-form-item__error"
                                                    v-if="
                                                        form.errors.has('name')
                                                    "
                                                    v-text="
                                                        form.errors.first(
                                                            'name'
                                                        )
                                                    "
                                                ></div>
                                            </el-form-item>

                                            <el-form-item
                                                :label="$t('post.label.option')"
                                                prop="option"
                                                :class="{
                                                    'el-form-item is-error':
                                                        form.errors.has(
                                                            'option'
                                                        ),
                                                }"
                                            >
                                                <el-select
                                                    v-model="modelForm.option"
                                                    placeholder="Select"
                                                >
                                                    <el-option
                                                        v-for="item in options"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <div
                                                    class="el-form-item__error"
                                                    v-if="
                                                        form.errors.has(
                                                            'option'
                                                        )
                                                    "
                                                    v-text="
                                                        form.errors.first(
                                                            'option'
                                                        )
                                                    "
                                                ></div>
                                            </el-form-item>

                                            <el-form-item
                                                :label="$t('post.label.sex')"
                                                prop="sex"
                                                :class="{
                                                    'el-form-item is-error':
                                                        form.errors.has('sex'),
                                                }"
                                            >
                                                <el-select
                                                    v-model="modelForm.sex"
                                                    placeholder="Select"
                                                >
                                                    <el-option
                                                        v-for="item in listSex"
                                                        :key="item.value"
                                                        :label="item.label"
                                                        :value="item.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <div
                                                    class="el-form-item__error"
                                                    v-if="
                                                        form.errors.has('sex')
                                                    "
                                                    v-text="
                                                        form.errors.first('sex')
                                                    "
                                                ></div>
                                            </el-form-item>
                                        </div>
                                    </div>
                                </el-form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import Form from "form-backend-validation";
import MultipleMedia from "../media/js/components/MultipleMedia";
import MultipleFileSelector from "../../mixins/MultipleFileSelector.js";
export default {
    props: {
        locales: { default: null },
        pageTitle: { default: null, String },
    },
    mixins: [MultipleFileSelector],
    components: {
        MultipleMedia,
    },
    data() {
        return {
            form: new Form(),
            loading: false,
            loadingPassword: false,
            formRules: {
                name: [
                    { required: true, message: "Bắt buộc", trigger: "submit" },
                ],
                code: [{ required: true, message: "", trigger: "submit" }],
            },
            modelForm: {
                name: "",
                option: "",
                sex: "",
            },

            options: [
                {
                    value: "Option1",
                    label: "Option1",
                },
                {
                    value: "Option2",
                    label: "Option2",
                },
                {
                    value: "Option3",
                    label: "Option3",
                },
                {
                    value: "Option4",
                    label: "Option4",
                },
                {
                    value: "Option5",
                    label: "Option5",
                },
            ],

            listSex: [
                {
                    value: 1,
                    label: "Nam",
                },
                {
                    value: 2,
                    label: "Nữ",
                },
            ],
        };
    },
    methods: {
        onSubmit() {
            this.form = new Form(_.merge(this.modelForm, {}));
            this.loading = true;

            this.form
                .post(this.getRoute())
                .then((response) => {
                    this.loading = false;
                    this.$notify({
                        type: "success",
                        title:
                            this.$route.params.postId !== undefined
                                ? "Cập nhật thành công"
                                : "Thêm mới thành công",

                        message: response.message,
                    });
                    this.$router.push({ name: "admin.post.index" });
                })
                .catch((error) => {
                    this.loading = false;
                    // this.$notify.error({
                    //     title: this.$route.params.postId !== undefined? 'Cập nhật thất bại': 'Thêm mới thất bại',
                    //     message: this.getSubmitError(this.form.errors),
                    // });
                });
        },

        onCancel() {
            this.$confirm(this.$t("mon.cancel.Are you sure to cancel?"), {
                confirmButtonText: this.$t("mon.cancel.Yes"),
                cancelButtonText: this.$t("mon.cancel.No"),
                type: "warning",
            })
                .then(() => {
                    this.$router.push({ name: "admin.post.index" });
                })
                .catch(() => {});
        },

        fetchData() {
            let routeUri = "";
            if (this.$route.params.postId !== undefined) {
                this.loading = true;
                routeUri = route("api.post.find", {
                    post: this.$route.params.postId,
                });
                window.axios.get(routeUri).then((response) => {
                    this.loading = false;
                    this.modelForm = response.data.data;
                    this.modelForm.is_new = false;
                });
            } else {
                this.modelForm.is_new = true;
            }
        },

        getRoute() {
            if (this.$route.params.postId !== undefined) {
                return route("api.post.update", {
                    post: this.$route.params.postId,
                });
            }
            return route("api.post.store");
        },
    },
    mounted() {
        this.fetchData();
    },
    computed: {},
};
</script>

<style scoped></style>
