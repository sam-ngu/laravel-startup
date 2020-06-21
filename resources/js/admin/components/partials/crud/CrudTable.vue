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
    export default {
        name: "CrudTable",
        data() {
            return {}
        },
        props: {},
        computed: {},
        methods: {},
        mounted() {

        },
    }
</script>

<style scoped>

</style>
