<template>
    <div>
        {{ game.appid }}
    </div>
</template>

<script>
export default {
    name: 'Game',
    props: {
        game: {
            type: Object,
            required: true,
        },
    },
    methods: {
    },
}
</script>

<style lang="scss">
</style>