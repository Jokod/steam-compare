<template>
    <div>
        <h1>Comparator</h1>
    </div>
</template>

<script>
import { mapState } from 'vuex'
import store from './store';

export default {
    name: 'Comparator',
    store: store,
    created() {
        this.load();
    },
    methods: {
        load() {
            console.log('Comparator loaded');
        },
    },
    computed: {
        ...mapState({
            user: state => state.user,
        }),
    },
}
</script>