<template>
    <profile-update-layout title="Phone">

        <template v-slot:body>
            <div>
                <v-form v-model="states.is_form_valid" @submit.prevent="save">

                    <v-text-field
                        @input="edit"
                        class="mx-12"
                        :rules="rules.phone"
                        label="Phone Number"
                        v-model="inputData.phone"
                        prepend-icon="mdi-phone"
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
        name: "ProfileUpdatePhone",
        mixins: [ProfileUpdateMixin],
        components: {ProfileUpdateLayout},
        data() {
            return {
                states: {
                    is_form_valid: true,
                    hasEdited: false,
                },
                inputData: {
                    phone: null
                },
                rules: {
                    phone: [
                        v => !!v || "required",
                        v => /((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/.test(v) || "Incorrect format.",
                    ]
                },
            }
        },
        mounted() {
            setTimeout(() => {
                this.inputData.phone = this.user.phone;
            })
        },
    }
</script>

<style scoped>

</style>
