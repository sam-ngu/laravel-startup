<template>

    <base-resource
        resource-url="/api/v1/roles"
        resource-name="Role"
        :actions="actions"
        :fields="resourceFields"
    />

</template>

<script>
import BaseResource from "../../components/crud-resource/BaseResource";
import BooleanField from "../../components/crud-resource/fields/BooleanField";
import TextField from "../../components/crud-resource/fields/TextField";
import DateField from "../../components/crud-resource/fields/DateField";
import {emailValidator} from "../../../utils/ValidationHelper"
import HasManyField from "../../components/crud-resource/fields/HasManyField";
import ArrayField from "../../components/crud-resource/fields/ArrayField";
export default {
    name: "BaseRole",
    components: {BaseResource},
    data() {
        return {
            actions: [],
            resourceFields: [
                {
                    label: 'Name',
                    key: 'name',
                    type: TextField,
                },
                {
                    label: 'Permissions',
                    key: 'permissions',
                    type: HasManyField,
                    hideOnIndex: false,
                    props: {
                        resourceUrl: '/api/v1/permissions',
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
