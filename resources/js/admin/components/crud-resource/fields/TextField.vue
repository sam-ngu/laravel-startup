<template functional>

    <article >
        <span v-if="props.mode === 'read'">{{ props.value }}</span>
<!--        edit mode  -->

        <v-text-field
            outlined
            hide-details="auto"
            v-else
            :rules="props.rules"
            :value="props.value"
            @input="listeners.input"
        />

    </article>
</template>

<script>
export default {
    name: "TextField",
    props: {
        mode: {
            type: String,
            default: 'read', // can be write or read
        },
        rules: {
            type: Array,
            default: () => []
        },
        value: '',
    },

}
</script>

<style scoped>

</style>
