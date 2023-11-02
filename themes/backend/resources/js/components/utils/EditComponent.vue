<template>

    <i class="far fa-edit" :disabled="disabled"
       @click.prevent="goToEditPage()" style = "cursor:pointer"></i>
</template>

<script>
    export default {
        props: {
            to: { type: Object, required: true },
            disabled: { type: Boolean, required:false, default: false}
        },
        methods: {
            goToEditPage() {
                this.$router.push(this.to);
            },
        },
    };
</script>
