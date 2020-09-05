<template>

    <section>

        <base-loader v-show="states.isLoading"/>

        <v-form v-show="!states.isLoading" ref="form" @submit.prevent="submit" v-model="states.isFormValid" lazy-validation>
            <v-container>
                <v-card class="p-6">
                    <v-card-text>

                        <v-row v-for="(field, index) in fields" :key="field.key">
                            <v-col cols="12" sm="4" md="4" lg="3" class="my-auto">
                                {{ field.label }}
                            </v-col>

                            <v-col cols="12" sm="5" md="6" lg="5">
                                <component
                                    v-bind="field.props && {...field.props}"
                                    :mode="field.readonly ? 'read' : 'write'"
                                    :is="field.type"
                                    v-model="inputData[field.key]"
                                />
                            </v-col>

                        </v-row>

                        <error-messages :errors="errors"/>

                    </v-card-text>

                    <v-card-actions>
                        <v-btn :disabled="!states.isFormValid" @click="submit" color="primary">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-container>
        </v-form>
    </section>


</template>

<script>
import BaseLoader from "../partials/BaseLoader";
import ErrorMessages from "../partials/ErrorMessages";
export default {
    name: "BaseUpdate",
    components: {ErrorMessages, BaseLoader},
    data() {
        return {
            states: {
                isFormValid: true,
                isLoading: true,
            },
            inputData: {},
            errors: [],
        }
    },
    props: {},
    computed: {
        resourceName() {
            return this.$route.meta.resourceName;
        },
        fields() {
            return this.$store.getters[`${this.resourceName}Management/fields`];
        }
    },
    methods: {
        submit(){
            if(!this.$refs.form.validate()){
                return ;
            }
            this.states.isLoading = true;
            const resourceId = this.$route.params.id;


            this.$store.dispatch(`${this.resourceName}Management/patchResource`, {
                id: resourceId,
                payload: this.inputData
            }).then((response) => {
                this.states.isLoading = false;
                this.$router.push({name: `${this.resourceName.toLowerCase()}-table`})
            }).catch((error) => {
                this.errors = error.response.data.errors;
                this.states.isLoading = false;
            })
        }
    },
    mounted() {
        // populate inputData with initial values
        const resourceId = this.$route.params.id;
        this.$store.dispatch(`${this.resourceName}Management/fetchResource`, resourceId)
            .then((response) => {
                // populate input data
                this.inputData = response.data.data;
                this.states.isLoading = false;
            })

    },
}
</script>

<style scoped>

</style>
