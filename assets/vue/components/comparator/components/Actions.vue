<template>
    <div class="d-flex justify-content-start align-items-center mb-4">
        <Random />
    </div>
</template>

<script>
import Random from './Actions/Random';

export default {
    name: 'Actions',
    components: {
        Random,
    },
}
</script>

<style lang="scss" scoped>
</style>