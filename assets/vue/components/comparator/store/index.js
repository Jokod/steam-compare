import Vue from 'vue'
import Vuex from 'vuex'
import ApiService from "../common/api.service";

Vue.use(Vuex)

export default new Vuex.Store({
    state () {
        return {
            user: null,
        }
    },
    
    mutations: {
        setUser: (state, user) => {
            state.user = user;
        },
    },

    actions: {
    }
})