import Vue from 'vue';
import Modal from './Modal.vue'

export default {
  open(params) {
    const instance = new Vue({
      render: h => h(Modal, { props: params })
    });
    document.body.appendChild(instance.$mount().$el);

    return instance;
  },
};