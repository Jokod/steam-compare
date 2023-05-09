import Vue from 'vue';
import Toast from "./components/toast/Toast";
import Comparator from "./components/comparator/Comparator";

Vue.config.productionTip = false

// Configure date format globally
import VueDateFns from "vue-date-fns";
import locale from "date-fns/locale/fr";
Vue.use(VueDateFns, "d MMMM yyyy", { locale });

// Configure vue-compat
import Toasted from 'vue-toasted';
Vue.use(Toasted);

import ModalVue from "./components/utils/ModalVue";
Vue.modal = ModalVue
Vue.prototype.$modal = ModalVue

const EventBus = new Vue();
Vue.prototype.$eventBus = EventBus;

new Vue({
    components: {
      Toast,
      Comparator,
    },
    el: '#app',
})