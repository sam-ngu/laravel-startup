<template>
    <layout-master>
        <v-container>
            <v-row justify="center" align="center">
                <v-col cols="12" sm="8" md="6">
                    <v-card>
                        <v-card-title>
                            <h2 class="text-center">Reset Password</h2>
                        </v-card-title>

                        <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">

                            <v-card-text>
                                <v-text-field
                                    type="email"
                                    label="Email"
                                    :error-messages="errors.email"
                                    :rules="rules.email"
                                    @change="errors={}"
                                    v-model="inputData.email"
                                />

                                <v-text-field
                                    type="password"
                                    label="Password"
                                    @change="errors={}"
                                    :error-messages="errors.password"
                                    :rules="rules.password"
                                    v-model="inputData.password"
                                />

                                <v-text-field
                                    type="password"
                                    label="Password Again"
                                    @change="errors={}"
                                    :rules="rules.password_confirmation"
                                    v-model="inputData.password_confirmation"
                                />



                            </v-card-text>

                        </v-form>

                        <v-card-actions>
                            <v-btn color="primary" :disabled="!states.is_form_valid" @click="submitForm">Reset</v-btn>
                        </v-card-actions>

                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </layout-master>
</template>

<script>
import LayoutMaster from "./layout/LayoutMaster";
import {swalMessage} from "../utils/swal/SwalHelper";
import {axiosErrorCallback} from "../utils/swal/AxiosHelper";
import {emailValidator} from "../utils/ValidationHelper";
export default {
    name: "BasePasswordReset",
    components: {LayoutMaster},
    data() {
        return {
            states: {
                is_form_valid: false
            },
            rules: {
                email: [
                    v => !!v || 'Required',
                    emailValidator,
                ],
                password: [
                    v => !!v || "Required",
                    v => (v && v.length >= 8) || "Password must be at least 8 characters"
                ],
                password_confirmation: [
                    v => !!v || "Required",
                    v => this.inputData.password ? ((v && v === this.inputData.password) || "Passwords do not match!") : true,
                ],
            },
            errors: {},
            inputData: {
                email: "",
                password: "",
                password_confirmation: "",
            },
        }
    },
    props: {
        resetToken: {
            type: String,
            required: true,
        }
    },
    computed: {},
    methods: {
        submitForm(){
            if(!this.$refs.form.validate()){
                swalMessage("error", "Please complete the form");
                return
            }
            const uri = '/reset-password';

            axios.post(uri, { ...this.inputData, token: this.resetToken })
                .then(function(response){
                    swalMessage("success", response.data.data)
                        .then(function (response) {
                            window.location = '/login';
                        });
                }.bind(this))
                .catch((response) => {
                    this.errors = response.response.data.errors;

                    // axiosErrorCallback
                })

        }
    },
    mounted() {

    },
}
</script>

<style scoped>

</style>
