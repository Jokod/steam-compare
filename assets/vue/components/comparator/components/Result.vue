<template>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <button v-if="isLoaded" @click="compare" class="btn btn-black" title="Compare"><i class="fa-solid fa-code-compare"></i></button>

        <div v-else-if="isCompared">
            <Game v-for="(game,index) in games" :key="index" :game="game"/>
        </div>

        <div v-else-if="isLoading">
            <i class="fa fa-arrows-spin fa-spin fa-2xl"></i>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import store from '../store';

import Game from './Game';

export default {
    name: 'Result',
    components: {
        Game,
    },
    store: store,
    data() {
        return {
            status: 'loaded',
        }
    },
    methods: {
        compare() {
            this.status = 'loading';
        }
    },
    computed: {
        ...mapState({
            friendsToCompare: state => state.friendsToCompare,
        }),
        isLoading() {
            return this.status === 'loading';
        },
        isLoaded() {
            return this.status === 'loaded';
        },
        isCompared() {
            return this.status === 'compared';
        },
        isErrored() {
            return this.status === 'error';
        },
    }
}
</script>

<style lang="scss">
</style>