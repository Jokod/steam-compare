import Vue from 'vue'
import Vuex from 'vuex'
import ApiService from "../common/api.service";

Vue.use(Vuex)

export default new Vuex.Store({
    state () {
        return {
            user: null,
            players: [],
            playersToCompare: [],
            interactive: true,
            filters: {
                free: true,
                appInfos: true,
            },
            games: {},
            gamesToCompare: {},
        }
    },

    getters: {
        getGames: state => {
            const selectedPlayers = state.players.filter(player => state.playersToCompare.includes(player.steamId));
            if (!selectedPlayers || selectedPlayers.length < 2) {
                return [];
            }

            const playersGames = selectedPlayers.map(player => player.games);
            if (playersGames.some(games => games.length === 0)) {
                return [];
            }

            const commonGames = playersGames.reduce((acc, games) => {
                return acc.filter(game => games.find(g => g.appid === game.appid));
            }, selectedPlayers[0].games);

            return commonGames;
        },
    },

    mutations: {
        setUser: (state, user) => {
            state.user = user;
        },
        addPlayer: (state, player) => {
            if (!state.players.find(p => p.steamId === player.steamId)) {
                state.players.push(player);
            }
        },
        addPlayerGames: (state, { steamId, games }) => {
            state.players.find(p => p.steamId === steamId).games = games;
        },
        addPlayerToCompare: (state, steamId) => {
            const index = state.playersToCompare.findIndex(p => p === steamId);
            (index === -1)
                ? state.playersToCompare.push(steamId)
                : state.playersToCompare.splice(index, 1);
        },
        setInteractive: (state, bool) => {
            state.interactive = bool;
        },
        setGames: (state, games) => {
            Object.keys(games).forEach(appId => {
                if (!state.games[appId]) {
                    state.games[appId] = games[appId];
                }
            }, {});
        },
        setGamesToCompare: (state, appIds) => {
            const gamesToCompare = {};
            for (const appId of appIds) {
                if (state.games[appId]) {
                    gamesToCompare[appId] = state.games[appId];
                }
            }
            state.gamesToCompare = gamesToCompare;
        },
        resetGamesToCompare: (state) => {
            state.gamesToCompare = {};
        }
    },

    actions: {
        async getUserInfos({commit, state}, steamId) {
            await ApiService.getUserInfos(steamId)
                .then(({data}) => {
                    commit('setUser', data)
                    commit('addPlayer', data.infos)
                    commit('addPlayerToCompare', data.infos.steamId);
                });
        },
        async getPlayerGames({commit, state}, steamId) {
            await ApiService.getPlayerGames(steamId, state.filters)
                .then((response) => {
                    commit('addPlayerGames', { steamId: steamId, games: response.data });
                });
        },
        async getGamesInfos({commit, state, getters}) {
            const appIds = getters.getGames.map(game => game.appid)
            const gameIds = Object.keys(state.games);

            const { data: games } = await ApiService.getGamesInfos(appIds, gameIds);

            commit('setGames', games);
            commit('setGamesToCompare', appIds);
        },
    }
})