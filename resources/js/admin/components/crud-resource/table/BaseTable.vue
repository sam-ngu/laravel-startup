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
                        <component
                            v-bind="header.props && {...header.props}"
                            mode="read"
                            :is="header.component"
                            :value="props.item[header.value]"
                        />
                    </div>
                </td>

                <!--action-->
                <td>
                    <!--delete button-->
                    <div @click.stop="deleteResource(props.item)">
                        <button-tooltip icon="mdi-delete" tooltip="Delete" />
                    </div>
                    <!--action dropdown-->
                    <div v-for="(action, index) in actions">

                    </div>

                </td>
            </tr>

        </template>
    </v-data-table>
</template>

<script>
import ButtonTooltip from "../../../../partials/ButtonTooltip";
export default {
    name: "BaseTable",
    components: {ButtonTooltip},
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
        actions(){
            return this.$store.getters[`${this.resourceName}Management/actions`];
        },
        headers(){
            const fields = this.$store.getters[`${this.resourceName}Management/fields`];

            return fields.map(field => {
                return {
                    ...field,
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
        },
        deleteResource(resource){
            this.$store.dispatch(`${this.resourceName}Management/deleteResource`, resource.id)
                .then((resource) => {

                })
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
