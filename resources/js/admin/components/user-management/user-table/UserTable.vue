<template>
    <v-data-table
        :headers="headers"
        :items="data"
        :items-per-page="data.length || 10000"
        :loading="isLoading"
        hide-default-footer
        class="elevation-3"
    >
        <template v-slot:item="props">
            <tr>
                <td class="px-2 text-left" >
                    <router-link :to="{
                                    name: 'user-show',
                                    params: {
                                        id: props.item.id,
                                        data: props.item,
                                        show: true,
                                    }
                                }">
                        {{ props.item.last_name }}
                    </router-link>
                </td>
                <td class="px-2 text-left">{{ props.item.first_name }}</td>
                <td class="px-2 text-left">{{ props.item.email }}</td>
                <td class="px-2 text-left">
                    <v-chip text-color="white" :color="props.item.confirmed_label ? 'green' : 'red'">
                        {{ props.item.confirmed_label ? 'Yes' : 'No' }}
                    </v-chip>
                </td>
                <td class="px-2 text-left">{{ props.item.roles_label }}</td>
                <td class="px-2 text-left">{{ props.item.permissions_label }}</td>
                <td class="px-2 text-left" v-html="props.item.social_buttons"></td>
                <td class="px-2 text-left">{{ props.item.updated_at }}</td>
                <td class="px-2 justify-center layout px-0">
                    <user-table-actions :user="props.item" />
                </td>
            </tr>

        </template>
    </v-data-table>
</template>

<script>

    import UserTableActions from "./UserTableActions";
    export default {
        name: "UserTable",
        components: {UserTableActions},
        data() {
            return {
                headers: [
                    {
                        text: 'Last Name',
                        align: 'left',
                        sortable: true,
                        value: 'last_name',
                        class: "px-2"
                    },
                    { text: 'First Name', value: 'first_name', sortable: true, class: "px-2" },
                    { text: 'E-mail', value: 'email', sortable: true, class: "px-2" },
                    { text: 'Confirmed', value: 'confirmed', sortable: false, class: "px-2" },
                    { text: 'Roles', value: 'roles', sortable: false, class: "px-2"},
                    { text: 'Other Permissions', value: 'other', sortable: false, class: "px-2" },
                    { text: 'Social', value: 'social', sortable: false, class: "px-2" },
                    { text: 'Last Updated', value: 'last_updated', sortable: false, class: "px-2" },
                    { text: 'Actions', value: 'action', sortable: false, class: "px-2" },
                ],
            }
        },
        props: {
            data: {
                type: Array,
                required: true
            },
            isLoading: {
                type: Boolean,
                required: true,
            }
        },
        computed: {},
        methods: {

        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
