<template>
    <el-dialog
        width="376px"
        :show-close="true"
        top="1vh"
        :destroy-on-close="true"
        :visible.sync="show_popup">
        <div class="fluid container" style="padding-left: 11px">
            <p class="f-config-title">Tuỳ chỉnh</p>
            <p  class="f-description">Điều chỉnh thứ tự hiển thị của các cột thông tin trong màn danh sách</p>
            <div class="col-12">
                <p  class="list-group-item-title">Hiển thị</p>
                <draggable class="list-group" tag="ul" v-model="list" v-bind="dragOptions" :move="onMove" @start="isDragging=true" @end="isDragging=false">
                    <transition-group type="transition" :name="'flip-list'">
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="element in list" :key="element.order">

                            <span class="f-config-item-text">{{element.name}}</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 14L16 14" stroke="#616161" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 10L16 10" stroke="#616161" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 6L16 6" stroke="#616161" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </li>
                    </transition-group>
                </draggable>
            </div>

            <div class="col-12">
                <p class="list-group-item-title">Không hiển thị</p>
                <draggable element="span" v-model="list2" v-bind="dragOptions" :move="onMove">
                    <transition-group name="no" class="list-group" tag="ul">
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="element in list2" :key="element.order">

                            <span>{{element.name}}</span>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 14L16 14" stroke="#616161" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 10L16 10" stroke="#616161" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 6L16 6" stroke="#616161" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>

                        </li>
                    </transition-group>
                </draggable>
            </div>


        </div>
        <div class="d-flex justify-content-end mt-5">
            <el-button size="small"  @click="closePopup" :loading="loading">{{$t('common.cancel')}}</el-button>
            <el-button size="small" type="primary" @click="onSubmitConfig" :loading="loading">{{$t('common.accept')}}</el-button>
        </div>
    </el-dialog>
</template>

<script>
    import draggable from "vuedraggable";
    import Form from "form-backend-validation";
    import _ from 'lodash'
    export default {
        props: {
            list_all_col: {
                type: Array,
                default: () => []
            },

            show_config : {default: false},
            table_name : {default: 'user'},

        },
        components: {
            draggable
        },

        data() {
            return {
                show_popup: this.show_config,
                form: new Form(),
                list2: [],
                list: [],
                editable: true,
                isDragging: false,
                delayedDragging: false,
                loading:false
            };
        },

        methods: {
            getListColSelected() {

                const properties = {
                    page: 1,
                    per_page: 100,
                    table_name: this.table_name,

                };

                window.axios.get(route("api.configdisplay.index", _.merge(properties, {})))
                    .then((response) => {

                        this.list = response.data.data.reverse().map((item, index) => {
                            let idx = _.findIndex(this.list_all_col,   {  col_name : item.col_name });
                            return _.merge(this.list_all_col[idx], {name:this.list_all_col[idx].name, order: index + 1});
                        });
                        this.list2 = this.list_all_col.filter(item => {
                            let idx = _.findIndex(response.data.data,   {  col_name : item.col_name });
                            return  idx < 0;
                        }).map((row, index) => {
                            return _.merge(row, {name:row.name, order: index + 1});
                        })
                        this.$emit("on-save-config", this.list) ;
                    });
            },
            orderList() {
                this.list = this.list.sort((one, two) => {
                    return one.order - two.order;
                });
            },
            onMove({ relatedContext, draggedContext }) {
                const relatedElement = relatedContext.element;
                const draggedElement = draggedContext.element;
                return (
                    (!relatedElement || !relatedElement.fixed) && !draggedElement.fixed
                );
            },
            getRouteSaveConfig() {
                return route('api.configdisplay.store');
            },

            onSubmitConfig() {
                this.form = new Form(  {list_col: this.list, table_name:'user'});
                this.loading = true;

                this.form.post(this.getRouteSaveConfig())
                    .then((response) => {
                        this.loading = false;
                        if(response.errors) {
                            this.$message({
                                type: 'error',

                                message: response.message
                            });

                        } else {
                            this.closePopup();
                            this.$emit("on-save-config", this.list) ;
                        }
                     })
                    .catch((error) => {

                        this.loading = false;
                        this.$notify.error({
                            title: this.$t('mon.error.Title'),
                            message: this.getSubmitError(this.form.errors),
                        });
                    });

            },

        },
        computed: {
            dragOptions() {
                return {
                    animation: 0,
                    group: "description",
                    disabled: !this.editable,
                    ghostClass: "ghost"
                };
            },
            listString() {
                return JSON.stringify(this.list, null, 2);
            },
            list2String() {
                return JSON.stringify(this.list2, null, 2);
            }
        },
        watch: {
            isDragging(newValue) {
                if (newValue) {
                    this.delayedDragging = true;
                    return;
                }
                this.$nextTick(() => {
                    this.delayedDragging = false;
                });
            },
            show_config(new_value) {
                this.show_popup = new_value;
            }
        },
        mounted() {
            this.getListColSelected();


        },
    };
</script>

<style>
    .flip-list-move {
        transition: transform 0.5s;
    }

    .no-move {
        transition: transform 0s;
    }

    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }

    .list-group {
        min-height: 20px;
    }

    .list-group-item {
        cursor: move;
        width: 313px;
        height: 32px;
        flex-shrink: 0;
        border-radius: 4px 4px 2px 2px;
        border: 1px solid #ECECF2;
        margin-bottom: 10px;
        background: #F5F5FA;

    }
      .list-group-item-title {
          color: #000;

          font-family: Roboto;
          font-size: 14px;
          font-style: normal;
          font-weight: 700;
          line-height: 20px;
    }

    .list-group-item i {
        cursor: pointer;

    }
    .list-group-item .f-config-item-text {
        color: #242424;
        font-family: Roboto;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
    }
    .f-description {
        width: 320px;
        color: #000;

        font-family: Roboto;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px; /* 142.857% */
    }
    .f-config-title {
        color: #252525;

        font-family: Roboto;
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: 24px; /* 133.333% */
    }
</style>
