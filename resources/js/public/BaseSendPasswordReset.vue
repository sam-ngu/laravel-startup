<template>
    <layout-master>

        <div style="height: 100%">
            <v-container align-content-center fill-height>
                <v-row align="center" justify="center" fill-height>
                    <v-card style="width: 400px">
                        <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">

                            <v-card-title class="text-center ">
                                <h3 class="text-center mx-auto title font-weight-bold">Forgot your password?</h3>
                                <h5 class="text-center mx-auto subtitle-2">Don't worry. We'll help you reset it.</h5>
                            </v-card-title>

                            <v-card-text>
                                <v-text-field
                                    label="Email Address"
                                    v-model="inputData.email"
                                    :rules="rules.email"
                                >
                                </v-text-field>
                            </v-card-text>

                            <v-card-actions>
                                <v-row column align="center">
                                    <v-col cols="6" >
                                        <v-btn
                                            :disabled="!states.is_form_valid"
                                            rounded
                                            color="primary white--text"
                                            @click="submitForm">Reset Password</v-btn>
                                    </v-col>
                                    <v-col cols="6"  class="mt-2">
                                        <v-btn  small text href="/login"><span class="body-1">Back</span></v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-row>

            </v-container>
        </div>

    </layout-master>
</template>
<script>

    import LayoutMaster from "./layout/LayoutMaster";
    import {emailValidator} from "../utils/ValidationHelper";
    import {swalLoader, swalMessage} from "../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../utils/swal/AxiosHelper";

    export default {
        name: "BasePasswordReset",
        components: { LayoutMaster},
        data() {
            return {
                states: {
                    is_form_valid: false
                },
                inputData: {
                    email: null,
                },
                rules: {
                    email: [
                        v => !!v || "Required",
                        emailValidator,
                    ]
                }

            }
        },
        props: {},
        computed: {},
        methods: {
            submitForm() {
                if(!this.$refs.form.validate())
                    return swalMessage('error', 'Please complete the form');
                swalLoader();
                let uri = '/forgot-password';

                return axios.post(uri, this.inputData)
                    .then((response) => swalMessage('success', response.data.message))
                    .then(() => window.location.href = '/')
                    .catch(response => axiosErrorCallback(response, response.response.data.error))
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
