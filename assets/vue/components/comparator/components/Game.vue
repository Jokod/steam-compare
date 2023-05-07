<template>
    <div>
        {{ appId }}
    </div>
</template>

<script>
export default {
    name: 'Game',
    props: {
        appId: {
            type: String,
            required: true,
        },
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