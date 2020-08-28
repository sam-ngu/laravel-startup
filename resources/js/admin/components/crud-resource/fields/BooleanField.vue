<template functional>
    <v-switch
        v-bind="{...$attrs}"
        :value="props.value"
        @input="($event) => $emit('input', $event)"
    >

    </v-switch>
</template>

<script>
export default {
    name: "BooleanField",
    props: {
        value: {
            type: Boolean,
            required: true,
        }
    },

}
</script>

<style scoped>

</style>
