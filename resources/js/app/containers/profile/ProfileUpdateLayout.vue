<template>
    <v-container>

        <v-row>
            <button-tooltip
                icon="mdi-arrow-left"
                tooltip="Back"
                @click="back"
            />
            <h3 class=" my-auto text-capitalize" v-text="title"></h3>
        </v-row>

        <v-divider></v-divider>

        <v-row justify="center" align="center">
            <v-col cols="12">
                <v-card >

                    <v-card-text>
                        <slot name="body">

                        </slot>
                    </v-card-text>

                    <v-card-actions>
                        <slot name="actions"></slot>

                    </v-card-actions>

                </v-card>

            </v-col>

        </v-row>

    </v-container>
</template>

<script>
    import ButtonTooltip from "../../../partials/ButtonTooltip";
    export default {
        name: "ProfileUpdateLayout",
        components: {ButtonTooltip},
        props: {
            title: {
                type: String,
                required: true,
            }
        },
        computed: {},
        methods: {
            back(){
                this.$router.push({
                    name: 'user-profile'
                })
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
