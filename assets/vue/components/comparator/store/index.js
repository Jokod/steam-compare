import Vue from 'vue'
import Vuex from 'vuex'
import ApiService from "../common/api.service";

Vue.use(Vuex)

export default new Vuex.Store({
    state () {
        return {
            steamId: null,
            user: null,

            interactive: true,
            filters: {
                free: true,
                appInfos: false,
            },
            friendsToCompare: [],

            compared: false,
        }
    },

    mutations: {
        setSteamId: (state, steamId) => {
            state.steamId = steamId;
        },
        setUser: (state, user) => {
            state.user = user;
        },
        friendSelected: (state, friend) => {
            (state.friendsToCompare.includes(friend))
                ? state.friendsToCompare.splice(state.friendsToCompare.indexOf(friend), 1)
                : state.friendsToCompare.push(friend);
        },
        setInteractive: (state, bool) => {
            state.interactive = bool;
        }
    },

    actions: {
        async getUserInfos({commit, state}) {
            await ApiService.getUserInfos(state.steamId, state.filters)
                .then(({data}) => {
                    commit('setUser', data);
                }
            );
        },
    }
})