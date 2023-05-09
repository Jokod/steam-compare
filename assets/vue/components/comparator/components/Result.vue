<template>
    <div class="d-flex justify-content-center flex-column align-items-center mt-5">
        <button v-if="!isLoading" @click="compare" class="btn btn-black my-4" title="Compare"><i class="fa-solid fa-code-compare"></i></button>
        <div v-else class="text-center">
            <i class="fa-solid fa-cloud-arrow-down fa-beat-fade fa-2xl"></i>
            <div class="mt-4">{{ textLoading }}</div>
        </div>

        <div v-if="isCompared">
            <div v-if="playersError.length > 0" class="alert alert-danger mt-3" role="alert">
                <p class="mb-0">Une erreur est survenue lors de la récupération des jeux de ces amis :</p>
                <ul>
                    <li v-for="(error,index) in playersError" :key="index">{{ error }}</li>
                </ul>
            </div>

            <Actions v-if="gamesToCompare" />

            <div class="game-cards">
                <Game class="game-card"
                    v-if="gamesToCompare"
                    v-for="(game,index) in gamesToCompare"
                    :key="index"
                    :params="paramsGame(game, index)"
                    />
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import store from '../store';

import Actions from './Actions';
import Game from './Game';

export default {
    name: 'Result',
    components: {
        Actions,
        Game,
    },
    store: store,
    data() {
        return {
            status: 'loaded',
            textLoading: 'Récupération des jeux...',
            playersError: [],
        }
    },
    methods: {
        async compare() {
            this.$store.commit('setInteractive', false);
            this.status = 'loading';

            this.$store.commit('resetGamesToCompare');

            for (const steamId of this.playersToCompare) {
                const player = this.players.find(p => p.steamId === steamId);
                this.textLoading = `Récupération des jeux de ${player.personaName}...`;

                if (!player.games) {
                    try {
                        await this.$store.dispatch('getPlayerGames', steamId);
                    } catch (e) {
                        this.playersError.push(player);
                    }
                } else {
                    await new Promise(resolve => setTimeout(resolve, 400));
                }
            }

            await this.getGamesInfos();

            this.$store.commit('setInteractive', true);
        },
        async getGamesInfos() {
            this.textLoading = `Récupération des données des jeux...`;

            await this.$store.dispatch('getGamesInfos')
                .then(() => {
                    this.status = 'compared';
                })
                .catch((e) => {
                    this.status = 'loaded';
                    this.$eventBus.$emit('createToast', {
                        title: 'Oups !',
                        message: e.response.data.message,
                        code: e.response.data.code
                    })
                });
        },
    },
    computed: {
        ...mapState({
            players: state => state.players,
            playersToCompare: state => state.playersToCompare,
            gamesToCompare: state => state.gamesToCompare,
        }),
        paramsGame() {
            return (game, index) => {
                return {
                    game: game,
                    appId: index,
                }
            }
        },
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

<style lang="scss" scoped>
.game-cards {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1.5rem;
}

.game-card {
  width: 300px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0px 10px rgba(0, 0, 0, 0.5);
  color: #fff;
}
</style>