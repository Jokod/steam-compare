<template>
    <div v-if="friends === null" class="py-2 text-center text-muted">
        <i class="fa-regular fa-circle-xmark fa-5x text-danger"></i>
        <div class="mt-4">Il semble que vous n'ayez pas d'amis ou que votre liste de contact est en privé.</div>
    </div>

    <div v-else class="d-flex justify-content-center gap-3 flex-wrap">
        <Friend v-for="(friend, index) in friends" :key="index" :friend="friend" />
    </div>
</template>

<script>
import { mapState } from 'vuex'

import Friend from './Friend';

export default {
    name: 'Friends',
    components: {
        Friend,
    },
    computed: {
        ...mapState({
            friends: state => state.user.friends,
        }),
    },
}
</script>

<style lang="scss" scoped>
</style>