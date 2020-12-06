<template>
    <v-container>

        <v-card class="pa-12 elevation-2">

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
                >
                </v-text-field>

                <v-container>
                    <v-subheader>Roles</v-subheader>
                    <v-row >
                        <v-col xs12 md6>
                            <v-card>
                                <v-switch label="Administrator" v-model="inputData.roles.administrator"></v-switch>
                                <v-card-text>
                                    All Permissions
                                </v-card-text>

                            </v-card>
                        </v-col>
                        <v-col xs12 md6>
                            <v-card>
                                <v-switch label="Executive" v-model="inputData.roles.executive"></v-switch>
                                <v-card-text>
                                    View-backend
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col xs12 md6>
                            <v-card>
                                <v-switch label="User" v-model="inputData.roles.user"></v-switch>
                                <v-card-text>
                                    None
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>

                <!--permission-->

                <v-container>
                    <v-subheader>Permissions</v-subheader>
                    <v-row >
                        <v-col xs12 md6>
                            <v-card>
                                <v-switch label="View Backend" v-model="inputData.permissions.view_backend"></v-switch>
                                <v-card-text>
                                    None
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>


            </v-form>

            <div>
                <v-btn label="submit" color="primary" block :disabled="!states.is_form_valid" @click="submitForm">Submit</v-btn>
            </div>

        </v-card>


    </v-container>
</template>

<script>
    import {emailValidator} from "../../../../utils/ValidationHelper";
    import {swalMessage, swalTimer} from "../../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

    export default {
        name: "UserCreateForm",
        data() {
            return {
                states: {
                    is_form_valid: false
                },
                inputData: {
                    first_name: null,
                    last_name: null,
                    email: null,
                    password: null,
                    active: true,
                    confirmed: true,
                    confirmation_email: true,
                    roles: {
                        administrator: false,
                        executive: false,
                        user: false,
                    },
                    permissions: {
                        view_backend: false,
                    }
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
                        v => this.inputData.password ? ((v && v === this.inputData.password) || "Passwords do not match!") : true,
                    ],
                    email: [
                        v => !!v || 'Required',
                        emailValidator,
                    ],

                }

            }
        },
        props: {

        },
        computed: {},
        methods: {
            submitForm(){
                if(!this.$refs.form.validate()){
                    swalMessage("error", "Please complete the form");
                    return
                }

                // reformatting input data for compatibility with default backend api
                this.inputData.roles = _.filter(_.map(this.inputData.roles, function (value, key) {
                    return value ? key : null
                }));

                this.inputData.permissions = _.filter(_.map(this.inputData.permissions, function (value, key) {
                    return value ? key.replace(/[_]/g, " ") : null
                }));
                this.inputData.active = Number(this.inputData.active);
                this.inputData.confirmed = Number(this.inputData.confirmed);
                this.inputData.confirmation_email = Number(this.inputData.confirmation_email);

                let uri = "/api/v1/users";

                axios.post(uri, this.inputData)
                    .then(function(response){

                        swalTimer("success");
                        this.$emit("user-created");
                        // EventBus.$emit("table-reload-required")
                    }.bind(this))
                    .catch(axiosErrorCallback)
            }

        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
