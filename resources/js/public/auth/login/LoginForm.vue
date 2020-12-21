<template>

    <v-card class="pa-12 elevation-2">
        <v-card-title>
            <h2 class="display-1 text-center mx-auto">
                <v-icon size="36">mdi-lock</v-icon> Sign in
            </h2>
        </v-card-title>
        <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">

            <v-text-field
                @keyup.enter="submitForm"
                label="Email Address"
                type="email"
                v-model="inputData.email"
                :rules="rules.email"
            >
            </v-text-field>

            <v-text-field
                @keyup.enter="submitForm"
                label="Password"
                type="password"
                v-model="inputData.password"
                :rules="rules.password"
            >
            </v-text-field>

            <v-checkbox
                label="Remember me"
                v-model="inputData.remember"
            >
            </v-checkbox>

        </v-form>

        <div>
            <v-btn label="submit" color="primary" block :disabled="!states.is_form_valid" @click="submitForm">Login</v-btn>
        </div>

        <div>
            <h6><a href="/password/reset">Forgot your password?</a> </h6>
            <h6><a href="/register">Don't have an account? Register here</a> </h6>
        </div>

    </v-card>

</template>

<script>
    import {emailValidator} from "../../../utils/ValidationHelper";
    import {swalLoader, swalMessage} from "../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../utils/swal/AxiosHelper";

    export default {
        name: "LoginForm",
        components: {},
        data() {
            return {
                states: {
                    is_form_valid: false
                },
                inputData: {
                    remember: true,
                    email: null,
                    password: null,
                },
                rules: {
                    password: [
                        v => !!v || "Required",
                    ],
                    email: [
                        v => !!v || 'Required',
                        emailValidator,
                    ],
                }
            }
        },
        props: {},
        computed: {},
        methods: {
            getCsrfToken(){
                return axios.get('/sanctum/csrf-cookie');
            },
            submitForm(){
                if(!this.$refs.form.validate()){
                    swalMessage("error", "Please complete the form");
                    return
                }
                swalLoader();

                let uri = "/login";

                this.getCsrfToken()
                    .then((response) => {
                        return axios.post(uri, this.inputData);
                    })
                    .then((response) => {
                        if(response.data.two_factor){
                            // show qr code challenge page
                        }else {
                            window.location = '/app';
                        }
                        // console.log(redirect)
                        // console.trace("login redirect");
                    })
                    .catch((response) => {
                        // if(response.)
                        response = response.response;
                        // console.log(response)
                        const payload = {
                            message: response.data.message,
                            errors: Object.values(response.data.errors).join('\n')
                        }
                        if(response.status !== 200) { // !!bad practice here, inconsistent api, this is to capture user is still under confirmation error
                            return swalMessage('error', payload)
                        }
                        axiosErrorCallback(response, response.data.message)
                    });
            },
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
