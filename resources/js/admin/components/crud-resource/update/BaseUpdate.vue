<template>

    <v-form>
        <v-container>
            <v-row v-for="(field, index) in fields" :key="field.key">
                <v-col cols="12" sm="5" md="4" lg="3">
                    {{ field.label }}
                </v-col>

                <v-col cols="12" sm="7" md="8" lg="9">
                    <component mode="update" :is="field.type" v-model="inputData[field.key]"/>
                </v-col>

            </v-row>
        </v-container>
    </v-form>

</template>

<script>
export default {
    name: "BaseUpdate",
    data() {
        return {
            inputData: {

            }
        }
    },
    props: {},
    computed: {
        resourceName(){
            return this.$route.meta.resourceName;
        },
        fields(){
            return this.$store.getters[`${this.resourceName}Management/fields`];
        }
    },
    methods: {},
    mounted() {

    },
}
</script>

<style scoped>

</style>
