<template>
    <v-container>

        <v-card
            class="mb-12 pa-12"
            v-if="!states.isLoading"
        >
            <v-card-title>
                <h3 class="title">Edit Role</h3>
                <v-btn class="ml-auto" color="primary" :disabled="!states.hasEdited" @click="submitForm">Update</v-btn>
            </v-card-title>


            <v-form ref="form" v-model="isFormValid" @submit.prevent="submitForm" >

                <v-text-field
                    @change="onEdit"
                    label="Name"
                    v-model="inputData.name"
                    :rules="rules.name"
                ></v-text-field>

                <v-container>
                    <v-subheader>Associated Permission</v-subheader>
                    <v-row>
                        <v-col xs12 md6 v-for="(item, index) in permissions" :key="index">
                            <v-card>
                                <v-switch
                                    :label="titleCase(item.name)"
                                    @change="onEdit"
                                    v-model="inputData.permissions[snakeCase(item.name)]">
                                </v-switch>

                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card>
        <loading-eclipse v-else></loading-eclipse>
    </v-container>
</template>

<script>
    import {EventBus} from "../../../../utils/event-bus";
    import LoadingEclipse from "../../../../utils/LoadingEclipse";
    import StringHelperMixin from "../../../../utils/mixins/StringHelperMixin";
    import PermissionMixin from "../common-role-mixin/PermissionMixin";
    import {swalMessage, swalTimer} from "../../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

    export default {
        name: "RoleUpdateForm",
        mixins: [StringHelperMixin, PermissionMixin],
        components: {LoadingEclipse},
        data() {
            return {
                states: {
                    hasEdited: false,
                    isLoading: false,
                },
                isFormValid: false, //validity of all forms, depending on rules
                rules: {
                    name: [
                        v => !!v || 'Name is required',
                        v => (v && v.length <= 30) || 'Name must be less than 30 characters'
                    ],
                },
                inputData: {
                    name: this.data.name,
                    permissions : {
                        view_backend: _.includes(_.flatMapDeep(this.data.permission, (item) => {return item.name}), 'view backend'),
                    }
                },
                permissions: [],  // store available permissions from api req
                apiMeta: {},
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
                this.inputData.permissions = _.filter(_.map(this.inputData.permissions, function (value, key) {
                    return value ? key.replace(/[_]/g, " ") : null
                }));

                let uri = "/api/v1/roles/" + String(this.data.id);

                axios.patch(uri, this.inputData)
                    .then(function(response){
                        swalTimer("success");
                        this.$emit("role-updated");
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
