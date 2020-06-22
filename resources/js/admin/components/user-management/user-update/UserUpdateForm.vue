<template>
    <v-container>

        <v-card
            class="mb-12 pa-12"
        >
            <v-card-title>
                <v-row justify="space-start">
                    <v-col>
                        <base-avatar :size="htmlAttr.avatarSize" :name="data.first_name" :avatar-location="data.avatar_location" />
                    </v-col>

                    <v-col>

                        <div>
                            <h5>Status:
                                <v-chip
                                        small
                                        :color="data.active ? 'success' : 'error'"
                                        text-color="white">
                                    {{data.active ? 'Active' : 'Inactive'}}
                                </v-chip>
                            </h5>
                            <h5>Confirmed:
                                <v-chip small :color="data.confirmed_label ? 'success' : 'error'" text-color="white">{{
                                    data.confirmed_label ? 'Yes' : 'No'
                                    }}</v-chip>
                            </h5>
                        </div>
                    </v-col>

                    <v-col>
                        <div>
                            <h5>Timezone: {{data.timezone ? data.timezone : 'Default'}}</h5>
                            <h5>Last login at: {{data.last_login_at ? data.last_login_at : 'N/A'}}</h5>
                            <h5>Last login IP: {{data.last_login_ip ? data.last_login_ip : 'N/A'}}</h5>

                        </div>

                    </v-col>


                </v-row>

                <v-btn class="ml-auto" color="primary" :disabled="!states.hasEdited" @click="submitForm">Update</v-btn>
            </v-card-title>


            <v-form ref="form" v-model="formsValidity.formEditDetails" @submit.prevent="submitForm" >

                <v-text-field
                    @change="onEdit"
                    label="First Name"
                    v-model="inputData.first_name"
                    :rules="rules.name"
                >
                </v-text-field>
                <v-text-field
                    @change="onEdit"
                    label="Last Name"
                    v-model="inputData.last_name"
                    :rules="rules.name"
                >
                </v-text-field>
                <v-text-field
                    @change="onEdit"
                    label="Email"
                    v-model="inputData.email"
                    :rules="rules.name"
                >
                </v-text-field>

                <v-text-field
                    @change="onEdit"
                    label="Change password"
                    v-model="inputData.password"
                    type="password"
                    :rules="rules.password"
                >
                </v-text-field>

                <v-text-field
                    @change="onEdit"
                    label="Password confirmation"
                    :rules="rules.password_again"
                    type="password"
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
        </v-card>
    </v-container>
</template>

<script>
    import BaseAvatar from "../../../../partials/BaseAvatar";
    import {emailValidator} from "../../../../utils/ValidationHelper";
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";
    import {swalTimer} from "../../../../utils/swal/SwalHelper";

    export default {
        name: "UserUpdateForm",
        components: {BaseAvatar},
        data() {
            return {
                htmlAttr: {
                    avatarSize: 75,
                },
                states: {
                    hasEdited: false,
                },
                formsValidity: { //validity of all forms, depending on rules
                    formEditDetails: false
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
                },
                inputData: {
                    first_name: this.data.first_name,
                    last_name: this.data.last_name,
                    email: this.data.email,
                    password: null,
                    active: this.data.active,
                    confirmed: this.data.confirmed_label,
                    roles: {
                        administrator: _.includes(this.data.roles_label.split(', '), 'Administrator'),
                        executive: _.includes(this.data.roles_label.split(', '), 'Executive'),
                        user: _.includes(this.data.roles_label.split(', '), 'User'),
                    },
                    permissions: {
                        view_backend: _.includes(this.data.permissions_label.split(', '), 'View Backend'),
                    }
                }
            }
        },
        props: {
            data: {
                type: Object,
                required: true,
            }
        },
        computed: {
        },
        methods: {
            onEdit(){
                this.states.hasEdited = true;
            },

            submitForm(){
                if(!this.states.hasEdited && !this.$refs.form.validate()){
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

                let uri = "/api/v1/users/" + String(this.data.id);

                axios.patch(uri, this.inputData)
                    .then(function(response){
                        swalTimer("success");
                        this.$emit("user-updated");
                        EventBus.$emit("table-reload-required")
                    }.bind(this))
                    .catch(axiosErrorCallback)
            },
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
