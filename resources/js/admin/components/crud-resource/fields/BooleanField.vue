<template functional>

    <article>
        <v-chip
            v-if="props.mode === 'read'"
            text-color="white"
            :color="props.value ? 'green' : 'red'"
        >
            {{ props.value ? 'Yes' : 'No' }}
        </v-chip>

        <v-switch

            v-else
            v-bind="{...$attrs}"
            :value="props.value"
            @input="($event) => $emit('input', $event)"
        >
        </v-switch>

    </article>
</template>

<script>
export default {
    name: "BooleanField",
    props: {
        value: {
            type: Boolean,
            required: true,
        },
        mode: {
            type: String,
            default: 'read'
        }
    },

}
</script>

<style scoped>

</style>
