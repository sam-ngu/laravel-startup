<template>
    <v-card class="pa-12 elevation-2">
        <v-card-title>
            <h2 class="display-1">
                <v-icon size="36">account_circle</v-icon> Account Registration
            </h2>
        </v-card-title>
        <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">
            <v-text-field
                label="First Name"
                v-model="inputData.first_name"
                :rules="rules.name"
            >
            </v-text-field>

            <v-text-field
                label="Last Name"
                v-model="inputData.last_name"
                :rules="rules.name"
            >
            </v-text-field>

            <v-text-field
                label="Email Address"
                type="email"
                v-model="inputData.email"
                :rules="rules.email"
            >
            </v-text-field>

            <v-select
                label="Where did you hear about us?"
                :items="sourceList"
                v-model="inputData.source"
                :rules="rules.source"
            >
            </v-select>

            <v-text-field
                label="Password"
                type="password"
                v-model="inputData.password"
                :rules="rules.password"
            >
            </v-text-field>

            <v-text-field
                label="Password Again"
                type="password"
                :rules="rules.password_again"
                v-model="inputData.password_confirmation"
            >
            </v-text-field>

            <v-checkbox
                :rules="rules.agreement"
                v-model="states.read_agreement"
            >
                <template v-slot:label>
                    <div class="my-auto">
                        I accept the <a href="/privacy-policy">privacy policy</a> and <a href="/terms-of-services">terms of services</a>.
                    </div>
                </template>
            </v-checkbox>

        </v-form>

        <div>
            <vue-recaptcha ref="recaptcha"
                           :sitekey="recaptchaKey"
                           @verify="onVerify"
                           @expired="onExpired"
                           size="invisible"

            >
            </vue-recaptcha>
            <v-btn label="submit" color="primary" block :disabled="!states.is_form_valid || !states.read_agreement" @click="submitForm">Submit</v-btn>
        </div>

    </v-card>
</template>

<script>
    import {emailValidator} from "../../../utils/ValidationHelper";
    import {swalLoader, swalMessage} from "../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../utils/swal/AxiosHelper";

    export default {
        name: "RegistrationForm",
        data() {
            return {
                states: {
                    is_form_valid: false,
                    read_agreement: false,
                },
                sourceList: [
                    'Google',
                    'Words of Mouth',
                    'Facebook',
                    'Other'
                ],
                inputData: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    password: null,
                    password_confirmation: null,
                    source: null,
                },
                rules: {
                    name: [
                        v => !!v || 'Name is required',
                        v => (v && v.length <= 30) || 'Name must be less than 30 characters'
                    ],
                    password: [
                        v => !!v || "Required",
                        v => (v && v.length >= 8) || "Password must be at least 8 characters"
                    ],
                    password_again: [
                        v => !!v || "Required",
                        v => this.inputData.password ? ((v && v === this.inputData.password) || "Passwords do not match!") : true,
                    ],
                    email: [
                        v => !!v || 'Required',
                        emailValidator,
                    ],
                    source: [
                        v => !!v || 'Required',
                    ],
                    agreement: [
                        v => !!v || 'Required',
                    ]
                }
            }
        },
        props: {
            recaptchaKey: {
                type: String,
                required: true,
            },
            enableRecaptcha: {
                type: Boolean,
                required: true
            }
        },
        computed: {},
        methods: {
            submitForm(){
                if(!this.$refs.form.validate()){
                    swalMessage("error", "Please complete the form");
                    return
                }
                this.submitCaptcha();

            },

            // for recaptcha
            submitCaptcha: function () {
                this.$refs.recaptcha.execute()
            },
            onVerify: function (response) {
                // console.log(response);
                // console.log('Verify: ' + response);

                swalLoader();
                this.inputData.captcha_token = response;

                let uri = "/register";

                axios.post(uri, this.inputData)
                    .then(function(response){

                        let redirect = response.data.redirect;
                        swalMessage("success", response.data.data)
                            .then(function (response) {
                                window.location = redirect;
                            });
                    }.bind(this))
                    .catch(axiosErrorCallback)

            },
            onExpired: function () {
                console.log('Expired')
            },
            resetRecaptcha () {
                this.$refs.recaptcha.reset() // Direct call reset method
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
