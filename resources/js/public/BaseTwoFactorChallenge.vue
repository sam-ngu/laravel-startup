<template>

    <layout-master>

        <v-container style="height: 100%">

            <v-row align="center" justify="center" style="height: 100%">

                <v-card width="500">

                    <v-card-title>
                        <h2 class="mx-auto">
                            <v-icon size="36">mdi-lock-outline</v-icon>
                            Security Verification
                        </h2>
                    </v-card-title>

                    <v-card-subtitle class="mt-2">
                        <p v-if="!states.useRecoveryCodes" class="text-center">
                            To secure your account, please enter the verification code from your Authenticator App.
                        </p>
                        <p v-else class="text-center">Please enter one of your recovery codes.</p>
                    </v-card-subtitle>


                    <v-card-text class="my-5">
                        <v-form v-model="states.is_form_valid" @submit.prevent="submit">

                            <v-text-field
                                v-if="!states.useRecoveryCodes"
                                label="Verification Code"
                                type="number"
                                outlined
                                :rules="rules.verification"
                                maxlength="6"
                                counter="6"
                                v-model="inputData.code"
                            />

                            <v-text-field
                                v-else
                                label="Recovery Code"
                                outlined
                                :rules="rules.required"
                                v-model="inputData.recovery_code"
                            />

                        </v-form>
                    </v-card-text>

                    <v-card-actions class="mt-5">
                        <v-btn block @click="submit" color="primary">
                            Submit
                        </v-btn>


                    </v-card-actions>

                    <v-card-actions >
                        <v-btn text block @click="toggleRecoveryCode">
                            {{ states.useRecoveryCodes ? 'Use Verification Code' : 'Enter recovery code instead' }}
                        </v-btn>
                    </v-card-actions>

                </v-card>

            </v-row>

        </v-container>

    </layout-master>

</template>

<script>
import LayoutMaster from "../public/layout/LayoutMaster";
export default {
    name: 'TwoFactorChallenge',
    components: {LayoutMaster},
    data() {
        return {
            states: {
                is_form_valid: false,
                useRecoveryCodes: false,
            },
            rules: {
                required: [
                    v => !!v || 'Required',
                ],
                verification: [
                    v => v && v.length === 6 || 'Please enter a 6-digit verification code.'
                ]
            },
            inputData: {
                code: "",
                recovery_code: "",
            }
        }
    },
    props: {},
    computed: {},
    methods: {
        toggleRecoveryCode(){
            this.states.useRecoveryCodes = !this.states.useRecoveryCodes;
        },
        submit(){

            let payload;

            if (this.states.useRecoveryCodes){
                payload = {recovery_code: this.inputData.recovery_code}
            }else {
                payload = {code: this.inputData.code}
            }

            axios.post('/two-factor-challenge', payload)
                .then((response) => {
                    // redirect to app page
                    window.location = '/app';
                })
        }
    },
    mounted() {

    },
}
</script>

<style scoped lang="scss">

</style>
