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
                        <p class="text-center">To secure your account, please enter the verification code from your Authenticator App.</p>
                    </v-card-subtitle>


                    <v-card-text class="my-5">
                        <v-form v-model="states.is_form_valid" @submit.prevent="submit">

                            <v-text-field
                                outlined
                                :rules="rules.verification"
                                maxlength="6"
                                counter="6"
                            >
                            </v-text-field>
                        </v-form>
                    </v-card-text>

                    <v-card-actions class="mt-5">
                        <v-btn block @click="submit" color="primary">
                            Submit
                        </v-btn>


                    </v-card-actions>

                    <v-card-actions >
                        <v-btn text block>
                            Enter recovery code instead
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
                is_form_valid: false
            },
            rules: {
                verification: [
                    v => !!v || 'Required',
                    v => v && v.length === 6 || 'Please enter a 6-digit verification code.'
                ]
            }
        }
    },
    props: {},
    computed: {},
    methods: {
        submit(){
            axios.post('/two-factor-verification', {

            }).then((response) => {
                // redirect to app page
            })
        }
    },
    mounted() {

    },
}
</script>

<style scoped lang="scss">

</style>
