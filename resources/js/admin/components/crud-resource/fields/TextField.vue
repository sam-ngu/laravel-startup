<template functional>

    <article >
        <span v-if="props.mode === 'read'">{{ props.value }}</span>
<!--        edit mode  -->

        <v-text-field
            solo
            hide-details
            v-else
            :value="props.value"
            @input="($event) => $emit('input', $event)"
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
        value: '',
    },

}
</script>

<style scoped>

</style>
