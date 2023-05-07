<template>
    <div v-if="this.isLoading" class="py-2 text-center text-muted">
        <i class="fa fa-circle-notch fa-spin me-2 align-middle"></i> Chargement en cours
    </div>

    <div v-else-if="this.isErrored" class="p-5 text-center text-muted">
        <i class="fa fa-5x fa-bug"></i>
        <div class="mt-4">Oups ! Il semblerait qu'une erreur se soit produite. <br />Veuillez réessayer dans quelques minutes.</div>
        <button @click="load" class="btn btn-black mt-2">Ressayer</button>
    </div>

    <div v-else-if="this.isLoaded">
        <Friends />
        <Result />
    </div>
</template>

<script>
import { mapState } from 'vuex'
import store from './store';

import Friends from './components/Friends.vue';
import Result from './components/Result.vue';

export default {
    name: 'Comparator',
    components: {
        Friends,
        Result,
    },
    store: store,
    props: {
        id: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            status: 'loading',
        }
    },
    created() {
        this.load();
    },
    methods: {
        async load() {
            this.status = 'loading';

            await this.$store.dispatch('getUserInfos', this.id)
                .then(() => this.status = 'loaded')
                .catch(() => {
                    this.status = 'error';

                    this.$eventBus.$emit('createToast', {
                        title: 'Erreur',
                        message: 'Une erreur est survenue lors du chargement des données, merci de ressayer plus tard.',
                        code: 'error'
                    })
                });
        },
    },
    computed: {
        ...mapState({
            user: state => state.user
        }),
        isLoaded() {
            return this.status === 'loaded';
        },
        isLoading() {
            return this.status === 'loading';
        },
        isErrored() {
            return this.status === 'error';
        },
    },
}
</script>

<style lang="scss" scoped>
</style>