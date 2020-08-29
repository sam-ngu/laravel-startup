<template>
    <v-data-table
        :headers="headers"
        :items="resources"
        :items-per-page="resources.length || 10000"
        :loading="states.isLoading"
        hide-default-footer
        class="elevation-3"
    >
        <template v-slot:item="props">
            <tr @click="redirectToUpdate(props.item)" style="cursor: pointer">
                <td  v-for="(header, index) in headers" :key="header.value">
                    <component  :is="header.component" :value="props.item[header.value]" />
                </td>
<!--                <td class="px-2 text-left" >-->
<!--                    <router-link :to="{-->
<!--                                    name: 'user-update',-->
<!--                                    params: {-->
<!--                                        id: props.item.id,-->
<!--                                        data: props.item,-->
<!--                                        show: true,-->
<!--                                    }-->
<!--                                }">-->
<!--                        {{ props.item.last_name }}-->
<!--                    </router-link>-->
<!--                </td>-->
<!--                <td class="px-2 text-left">{{ props.item.first_name }}</td>-->
<!--                <td class="px-2 text-left">{{ props.item.email }}</td>-->
<!--                <td class="px-2 text-left">-->
<!--                    <v-chip text-color="white" :color="props.item.confirmed_label ? 'green' : 'red'">-->
<!--                        {{ props.item.confirmed_label ? 'Yes' : 'No' }}-->
<!--                    </v-chip>-->
<!--                </td>-->
<!--                <td class="px-2 text-left">{{ props.item.roles_label }}</td>-->
<!--                <td class="px-2 text-left">{{ props.item.permissions_label }}</td>-->
<!--                <td class="px-2 text-left" v-html="props.item.social_buttons"></td>-->
<!--                <td class="px-2 text-left">{{ props.item.updated_at }}</td>-->
<!--                <td class="px-2 justify-center layout px-0">-->
<!--                    <user-table-actions :user="props.item" />-->
<!--                </td>-->
            </tr>

        </template>
    </v-data-table>
</template>

<script>
export default {
    name: "BaseTable",
    data() {
        return {
            resources: [],
            states: {
                isLoading: false,
            }
        }
    },
    props: {

    },
    computed: {
        resourceName(){
            return this.$route.meta.resourceName;
        },
        headers(){
            const fields = this.$store.getters[`${this.resourceName}Management/fields`];

            return fields.map(field => {
                return {
                    text: field.label,
                    value: field.key,
                    sortable: field.sortable,  // FIXME: server sided sort
                    align: 'left',
                    component: field.type,
                }
            })
        }
    },
    methods: {
        redirectToUpdate(resource){
            this.$router.push({name: `${this.resourceName}-update`, id: resource.id });
        }
    },
    mounted() {
        this.$store.dispatch(`${this.resourceName}Management/fetchResources`)
            .then((response) => {
                this.resources = response.data.data;
            })
    },
}
</script>

<style scoped>

</style>
