<template>

    <base-resource
        resource-url="/api/v1/users"
        resource-name="User"
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
import {axiosErrorCallback} from "../../../utils/swal/AxiosHelper";
export default {
    name: "BaseUser",
    components: {BaseResource},
    data() {
        return {
            actions: [
                {
                    label: 'Login As User',
                    show: true,
                    onclick: (resource) => {
                        const uri = `/api/v1/users/${resource.id}/login-as`
                        axios.post(uri)
                            .then(() => {
                                window.location.href = '/';
                            }).catch(axiosErrorCallback);

                    },
                    disabled: false
                },
            ],
            resourceFields: [
                {
                    label: 'Name',
                    key: 'name',
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
