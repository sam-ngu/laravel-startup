<template>

    <base-resource resource-name="User" :fields="resourceFields" :resources="resources" />

</template>

<script>
import BaseResource from "../../components/crud-resource/BaseResource";
import BooleanField from "../../components/crud-resource/fields/BooleanField";
export default {
    name: "BaseUser",
    components: {BaseResource},
    data() {
        return {
            resources: [],
            resourceFields: [
                {
                    label: 'First Name',
                    type: BooleanField,
                },
                {
                    label: 'Last Name',
                    type: BooleanField,
                },
                {
                    label: 'Active',
                    type: BooleanField,
                },
            ]
        }
    },
    props: {},
    computed: {},
    methods: {},
    mounted() {
        axios.get('/api/v1/users')
            .then((response) => {
                this.resources = response.data.data;
            })
    },
}
</script>

<style scoped>

</style>
