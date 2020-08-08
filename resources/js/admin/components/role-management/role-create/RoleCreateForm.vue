<template>
    <v-container>

        <v-card class="pa-12 elevation-2">

            <v-form ref="form" v-model="states.is_form_valid" @submit.prevent="submitForm">
                <v-text-field
                    label="Name"
                    v-model="inputData.name"
                    :rules="rules.name"
                >
                </v-text-field>

                <!--permission-->
                <v-container>
                    <v-subheader>Associated Permission</v-subheader>
                    <v-row >
                        <v-col xs12 md6 v-for="(item, index) in permissions" :key="index">
                            <v-card>
                                <v-switch
                                    :label="titleCase(item.name)"
                                    v-model="inputData.permissions[snakeCase(item.name)]">
                                </v-switch>

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
    import PermissionMixin from "../common-role-mixin/PermissionMixin";
    import StringHelperMixin from "../../../../utils/mixins/StringHelperMixin";
    import {swalMessage, swalTimer} from "../../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

    export default {
        name: "RoleCreateForm",
        components: {},
        mixins: [StringHelperMixin, PermissionMixin],
        data() {
            return {
                states: {
                    is_form_valid: false
                },
                inputData: {
                    name: null,

                    permissions: {
                        view_backend: false,
                    },
                    guard_name : "web",
                },
                rules: {
                    name: [
                        v => !!v || 'Name is required',
                        v => (v && v.length <= 30) || 'Name must be less than 30 characters'
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

                this.inputData.permissions = _.filter(_.map(this.inputData.permissions, function (value, key) {
                    return value ? key.replace(/[_]/g, " ") : null
                }));

                let uri = "/api/v1/roles";

                axios.post(uri, this.inputData)
                    .then(function(response){
                        swalTimer("success");
                        this.$emit("role-created");
                        // EventBus.$emit("table-reload-required")
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
