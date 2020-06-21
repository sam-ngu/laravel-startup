<template>

    <v-tooltip
        bottom
    >
        <template v-slot:activator="{on}">
            <div v-on="on">
                <v-btn
                    :color="color"
                    @click="$emit('click')"
                    :small="small"
                    :icon="!!icon"
                    :disabled="disabled"
                    :to="to"
                >
                    <v-icon v-if="icon">{{icon}}</v-icon>
                    {{btnText}}
                </v-btn>
            </div>
        </template>
        <span>{{tooltip}}</span>
    </v-tooltip>
</template>

<script>
    export default {
        name: "ButtonTooltip",
        data() {
            return {}
        },
        props: {
            tooltip: {
                type: String,
                required: true,
            },
            color: {
                type: String,
                default: null
            },
            icon: {
                type: String,
                default: null
            },
            small: {
                type: Boolean,
                default: true,
            },
            btnText: {
                type: String,
                default: null
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            to: {
                type: String | Object,
                default: null
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
