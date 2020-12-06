<template>

    <article>
        <p class="error--text" v-for="(error, key) in errors" :key="error"> {{key.toUpperCase()}}: {{ error }}</p>

    </article>

</template>

<script>
export default {
    name: "ErrorMessages",
    data() {
        return {}
    },
    props: {
        errors: {
            type: Object|Array,
            default: () => {},
        }
    },
    computed: {},
    methods: {},
    mounted() {

    },
}
</script>

<style scoped>

</style>
