<template>
  <div v-if="isOpen">
    <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" :class="sizeClass" role="document">
        <div class="modal-content">
          <div class="modal-header align-items-center">
            <h5 v-if="title" class="display-8 text-secondary font-weight-bold modal-title m-0" id="exampleModalLabel">{{ title }}</h5>
            <button @click.once="close" type="button" class="close" data-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true"><i class="fa fa-times"></i> </span>
            </button>
          </div>
          <div class="modal-body">
            <component :is="component" :params="params" @close="close"></component>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-backdrop fade show"></div>
  </div>
</template>

<script>
export default {
  name: "Modal",
  props: {
    component: { type: Object, required: true },
    title: { type: String, required: false },
    size: { type: String, required: false, default: 'md' },
    params: { type: Object, required: false },
  },
  data() {
    return {
      isOpen: false,
    }
  },
  created: function() {
    this.isOpen = true
  },
  methods: {
    close() {
      this.isOpen = false
    }
  },
  computed: {
    sizeClass() {
      return 'modal-' + this.size
    }
  }
}
</script>

<style lang="scss" scoped>
.close {
  border: none 0;
  background-color: transparent;
}
</style>
