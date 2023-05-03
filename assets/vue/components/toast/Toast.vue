<template>
</template>

<script>
export default {
    name: 'Toast',
    created() {
        this.$eventBus.$on('createToast', (data) => {
            this.makeToast(data.title, data.message, data.code)
        });
    },
    methods: {
        makeToast(title, message, code) {
            this.$toasted.show(message, {
                theme: "toasted-primary", 
                position: "bottom-left", 
                duration : 5000,
                type: code,
                name: title,
                keepOnHover: true,
                iconPack: 'fontawesome',
            })
        },
    },
}
</script>