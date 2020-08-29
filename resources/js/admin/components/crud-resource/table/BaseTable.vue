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
                <td  v-for="(header, index) in headers" :key="header.value" >
                    <div @click.stop="() => {}" style="display: inline-block; width: fit-content; cursor: default">
                        <component :is="header.component" :value="props.item[header.value]" />
                    </div>
                </td>
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
            this.$router.push({
                name: `${this.resourceName}-update`,
                params: {
                    id: resource.id
                }
            });
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
