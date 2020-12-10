<template>
    <profile-update-layout title="Name">

        <template v-slot:body>

            <div>
                <v-form v-model="states.is_form_valid" @submit.prevent="save">

                    <v-text-field
                        @input="edit"
                        class="mx-12"
                        :rules="rules.name"
                        label="First Name"
                        v-model="inputData.first_name"
                    ></v-text-field>

                    <v-text-field
                        @input="edit"
                        class="mx-12"
                        :rules="rules.name"
                        label="Last Name"
                        v-model="inputData.last_name"
                    ></v-text-field>

                </v-form>

            </div>
        </template>

        <template v-slot:actions>
            <div class="ml-auto">
                <v-btn color="primary" :disabled="!states.hasEdited || !states.is_form_valid" text @click="save">
                    Save
                </v-btn>
            </div>
        </template>

    </profile-update-layout>
</template>

<script>
    import ProfileUpdateLayout from "../ProfileUpdateLayout";
    import ProfileUpdateMixin from "../ProfileUpdateMixin";

    export default {
        name: "ProfileUpdateName",
        components: {ProfileUpdateLayout},
        mixins: [ProfileUpdateMixin],
        data() {
            return {
                states: {
                    is_form_valid: true,
                    hasEdited: false,
                },
                inputData: {
                    first_name: null,
                    last_name: null,
                },
                rules: {

                },
            }
        },
        mounted() {

            // store not available immediately in mounted hook
            setTimeout(() => {
                this.inputData.first_name = this.user.first_name;
                this.inputData.last_name = this.user.last_name;
            })

        },
    }
</script>

<style scoped>

</style>
