<template>

    <v-form ref="form" @submit.prevent="submit" v-model="states.is_form_valid" lazy-validation>

        <v-container>
            <v-card class="p-6">
                <v-card-text>

                    <v-row v-for="(field, index) in fields" :key="field.key">
                        <v-col cols="12" sm="4" md="4" lg="3" class="my-auto">
                            {{ field.label }}
                        </v-col>

                        <v-col cols="12" sm="5" md="6" lg="5">
                            <component
                                v-bind="{...field.options}"
                                :mode="field.readonly ? 'read' : 'write'"
                                :rules="field.rules"
                                :is="field.type"
                                v-model="inputData[field.key]"/>
                        </v-col>

                    </v-row>
                </v-card-text>

                <v-card-actions>
                    <v-btn @click="submit" color="primary">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-container>
    </v-form>

</template>

<script>
export default {
    name: "BaseUpdate",
    data() {
        return {
            states: {
                is_form_valid: true,
            },
            inputData: {}
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
            const resourceId = this.$route.params.id;

            this.$store.dispatch(`${this.resourceName}Management/patchResource`, {
                id: resourceId,
                payload: this.inputData
            }).then((response) => {

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
            })

    },
}
</script>

<style scoped>

</style>
