import Vue from 'vue';

const mixin = {
    data() {
        return {
            pagingSetting: {
                layout: this.$isMobile() ? 'total,   prev, pager, next' : 'total, sizes, prev, pager, next, jumper'
            },
            meta: {
                current_page: 1,
                per_page: 20,
            },
            order_meta: {
                order_by: '',
                order: '',
            },
            links: {},
            searchQuery: '',
            tableIsLoading: false,
            show_popup: false,

        }
    },
    methods: {
        convertArrayToObject (array_convert, key, value)  {
        const initialValue = {};
        return array_convert.reduce((obj, item) => {
            return {
                ...obj,
                [item[key]]: item[value],
            };
        }, initialValue);
    },
        closePopup() {
            this.show_popup = false
            this.$emit("close-popup") ;
        },
        gotoPage(route) {
            this.$router.push(route)
        },
        getSubmitError(error) {
            const firstPropValue = Object.values(error.errors)[0];
            return firstPropValue[0];
        },
        fetchData() {
            this.tableIsLoading = true;
            this.queryServer({per_page: 20});
        },

        handleSizeChange(event) {
            this.tableIsLoading = true;
            this.queryServer({per_page: event});
        },
        handleCurrentChange(event) {
            this.tableIsLoading = true;
            this.queryServer({page: event});
        },
        handleSortChange(event) {
            this.tableIsLoading = true;
            this.queryServer({order_by: event.prop, order: event.order});
        },
        performSearch: _.debounce(function (query) {
            this.tableIsLoading = true;
            this.queryServer({search: query.target.value});
        }, 300),
        slugify (string) {
            let value
            // string = string.toString();
            value = string.replace(/^\s+|\s+$/g, '') // trim
            value = value.toLowerCase()

            // remove accents, swap ñ for n, etc
            const from = 'äëïîöüûñçáàảạãăắằẳẵặâấầẩẫậéèẻẽẹêếềểễệíìỉĩịóòỏõọôốồổỗộơớờởỡợúùủũụưứừửữựýỳỷỹỵđ·/_,:;'
            const to = 'aeiiouuncaaaaaaaaaaaaaaaaaeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyd------'
            for (let i = 0, l = from.length; i < l; i++) {
                value = value.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
            }

            value = value.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-') // collapse dashes

            return value
        },
        getObjetValue (obj, keys) {
            return keys.split('.').reduce(function (cur, key) {
                return cur[key];
            }, obj);
        }

    },
};
Vue.mixin(mixin);
Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});
