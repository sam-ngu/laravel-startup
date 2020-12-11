<template>
    <profile-update-layout title="Password">

        <template v-slot:body>
            <div >
                <v-form v-model="states.is_form_valid" @submit.prevent="save">

                    <v-text-field
                        @input="edit"
                        type="password"
                        class="mx-12"
                        :rules="rules.old_password"
                        label="Old Password"
                        v-model="inputData.old_password"
                    ></v-text-field>

<!--                    <v-text-field-->
<!--                        @input="edit"-->
<!--                        type="password"-->
<!--                        class="mx-12"-->
<!--                        :rules="rules.password"-->
<!--                        label="Password"-->
<!--                        v-model="inputData.password"-->
<!--                    ></v-text-field>-->
                    <text-field-password
                        @input="edit"
                        :rules="rules.password"
                        label="Password"
                        v-model="inputData.password"
                    />

                    <text-field-password
                        @input="edit"
                        :rules="rules.password_again"
                        label="Password Again"
                        v-model="inputData.password_again"
                    />
<!--                    <v-text-field-->
<!--                        @input="edit"-->
<!--                        type="password"-->
<!--                        class="mx-12"-->
<!--                        :rules="rules.password_again"-->
<!--                        label="Password Again"-->
<!--                        v-model="inputData.password_again"-->
<!--                    ></v-text-field>-->

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
    import TextFieldPassword from "../../../components/TextFieldPassword";

    export default {
        name: "ProfileUpdatePassword",
        mixins: [ProfileUpdateMixin],
        components: {TextFieldPassword, ProfileUpdateLayout},
        data() {
            return {
                states: {
                    is_form_valid: true,
                    hasEdited: false,
                },
                inputData: {
                    old_password: null,
                    password: null,
                    password_again: null,
                },
                rules: {
                    old_password: [
                        v => !!v || "Required",
                    ],
                    password: [
                        v => !!v || "Required",
                        v => (v && v.length >= 8) || "Password must be at least 8 characters",
                        v => (v && /[a-z]/.test(v)) || "Password must contain lowercase",
                        v => (v && /[A-Z]/.test(v)) || "Password must contain uppercase",
                        v => (v && /[0-9]/.test(v)) || "Password must contain number",
                        v => (v && /[@$!%*#?&]/.test(v)) || "Password must contain special characters",
                    ],
                    password_again: [
                        v => !!v || "Required",
                        v => this.inputData.password ? ((v && v === this.inputData.password) || "Passwords do not match!") : true,
                    ],
                },
            }
        },

    }
</script>

<style scoped>

</style>
