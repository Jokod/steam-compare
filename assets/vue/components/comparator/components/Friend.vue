<template>
    <div class="d-flex flex-column justify-content-center align-items-center">
        <img class="mb-2"
            @click="selected"
            :src="friend.avatarMedium"
            :alt="friend.personaName"
            :title="friend.personaName"
            :class="{'selected' : isSelected, 'interactive': !isInteractive}"
            >
        <p>{{ friend.personaName }}</p>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import store from '../store';

export default {
    name: 'Friend',
    store: store,
    props: {
        friend: {
            type: Object,
            required: true,
        },
    },
    methods: {
        selected() {
            if (this.interactive) {
                this.$store.commit('resetGames');
                this.$store.commit('addPlayer', this.friend);
                this.$store.commit('addPlayerToCompare', this.friend.steamId);
            }
        }
    },
    computed: {
        ...mapState({
            playersToCompare: state => state.playersToCompare,
            interactive: state => state.interactive,
        }),
        isSelected() {
            return this.playersToCompare.some(steamId => steamId === this.friend.steamId);
        },
        isInteractive() {
            return this.interactive;
        }
    }
}
</script>

<style lang="scss">
img {
    transition: all 0.2s ease-in-out;

    &:not(.interactive):hover {
        cursor: pointer;
        transform: scale(1.1);
    }
}
.selected {
    transform: scale(1.1);
    box-shadow: 0 0 0 0.2rem #fff;
}
</style>