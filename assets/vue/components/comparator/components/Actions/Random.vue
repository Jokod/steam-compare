<template>
    <button @click="getOneGameRandomly" class="btn btn-success" title="Random"><i class="fa-solid fa-shuffle"></i></button>
</template>

<script>
import { mapState } from 'vuex'
import store from '../../store';

import Game from '../Game';

export default {
    name: 'Random',
    store: store,
    methods: {
        getOneGameRandomly() {
            const keys = Object.keys(this.gamesToCompare);
            const randomKey = keys[Math.floor(Math.random() * keys.length)];
            const game = this.gamesToCompare[randomKey];

            this.$modal.open({
                title: game.name,
                component: Game,
                params: {
                    game: game,
                    appId: randomKey,
                },
            })
        }
    },
    computed: {
        ...mapState({
            gamesToCompare: state => state.gamesToCompare,
        }),
    }
}
</script>

<style lang="scss" scoped>
</style>