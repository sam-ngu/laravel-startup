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
import DateField from "../../components/crud-resource/fields/DateField";
import {emailValidator} from "../../../utils/ValidationHelper"
import HasManyField from "../../components/crud-resource/fields/HasManyField";
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
                    label: 'Email',
                    key: 'email',
                    type: TextField,
                    props: {
                        rules: [
                            v => !!v || 'Required',
                            emailValidator,
                        ]
                    }
                },
                {
                    label: 'Confirmed',
                    key: 'confirmed',
                    type: BooleanField,
                },
                {
                    label: 'Active',
                    key: 'active',
                    type: BooleanField,
                },
                {
                    label: 'Roles',
                    key: 'roles',
                    type: HasManyField,
                    props: {
                        resourceUrl: '/api/v1/roles',
                        searchable: true,
                        itemText: 'name',
                        itemValue: 'id',

                    }
                },

                {
                    label: 'Created At',
                    key: 'created_at',
                    type: DateField,
                    readonly: true,
                },
            ]
        }
    },
}
</script>

<style scoped>

</style>
