<template>

    <base-resource
        resource-url="/api/v1/users"
        resource-name="User"
        :fields="resourceFields"
        :resources="resources"
    />

</template>

<script>
import BaseResource from "../../components/crud-resource/BaseResource";
import BooleanField from "../../components/crud-resource/fields/BooleanField";
import TextField from "../../components/crud-resource/fields/TextField";
export default {
    name: "BaseUser",
    components: {BaseResource},
    data() {
        return {
            resources: [],
            resourceFields: [
                {
                    label: 'First Name',
                    key: 'first_name',
                    type: TextField,
                },
                {
                    label: 'Last Name',
                    key: 'last_name',
                    type: TextField,
                },
                {
                    label: 'Active',
                    key: 'active',
                    type: BooleanField,
                },
            ]
        }
    },
}
</script>

<style scoped>

</style>
