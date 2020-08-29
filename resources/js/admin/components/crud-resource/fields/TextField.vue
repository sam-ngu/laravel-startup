<template functional>

    <article>
        <span v-if="props.mode === 'read'">{{ props.value }}</span>
<!--        edit mode  -->

        <v-text-field
            v-else

        />

    </article>

</template>

<script>
export default {
    name: "TextField",
    props: {
        mode: {
            type: String,
            default: 'read', // can be create, or update or read
        },
        value: '',
    },

}
</script>

<style scoped>

</style>
