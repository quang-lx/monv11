require('./bootstrap');

window._ = require('lodash');

import Vue from 'vue';
import VueI18n from 'vue-i18n';
import ElementUI from 'element-ui';
import DataTables from 'vue-data-tables';
import VueEvents from 'vue-events';
import locale from 'element-ui/lib/locale/lang/vi';
 import 'element-ui/lib/theme-chalk/index.css'
import Locale from './vue-i18n-locales.generated';
import router from './routers';

import ReloadDeleteComponent from './components/utils/ReloadDeleteComponent.vue';
import DeleteComponent from './components/utils/DeleteComponent.vue';
import EditComponent from './components/utils/EditComponent.vue';
import SingleMedia from './components/media/js/components/SingleMedia.vue';
import MediaManager from './components/media/js/components/MediaManager.vue';
import Clipboard from 'v-clipboard'

import VueMobileDetection from 'vue-mobile-detection'
Vue.use(VueMobileDetection)
Vue.use(ElementUI, { locale });
Vue.use(DataTables, { locale });
Vue.use(VueI18n);
Vue.use(Clipboard)

Vue.use(require('vue-shortkey'), { prevent: ['input', 'textarea'] });

Vue.use(VueEvents);
require('./mixins');

Vue.component('ReloadDeleteButton', ReloadDeleteComponent);
Vue.component('DeleteButton', DeleteComponent);
Vue.component('EditButton',  EditComponent);
Vue.component('SingleMedia', SingleMedia);
Vue.component('MediaManager', MediaManager);


const currentLocale = window.MonCMS.currentLocale;


const i18n = new VueI18n({
    locale: currentLocale,
    messages: Locale
});

const app = new Vue({
    el: '#app',

    router,
    i18n,


});
