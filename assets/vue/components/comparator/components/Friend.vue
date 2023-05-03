<template>
    <img
        @click="selected"
        :src="friend.avatarMedium"
        :alt="friend.personaName"
        :title="friend.personaName"
        :class="{'selected' : isSelected, 'interactive': !isInteractive}"
        >
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
            if (this.interactive)
                this.$store.commit('friendSelected', this.friend.steamId)
        }
    },
    computed: {
        ...mapState({
            friendsToCompare: state => state.friendsToCompare,
            interactive: state => state.interactive,
        }),
        isSelected() {
            return this.friendsToCompare.includes(this.friend.steamId);
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
        transform: scale(1.2);
    }
}
.selected {
    transform: scale(1.2);
    box-shadow: 0 0 0 0.2rem #fff;
}
</style>