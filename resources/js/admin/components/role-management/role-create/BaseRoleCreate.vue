<template>
    <collapsible-sidebar v-model="show"  @dismiss-sidebar="back">
        <template slot="header">
            <h1>Create Role</h1>
        </template>

        <template slot="content">
            <v-container>
                <v-row >
                    <v-col>
                        <role-create-form @role-created="back"/>

                    </v-col>
                </v-row>
            </v-container>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../utils/CollapsibleSidebar";
    import RoleCreateForm from "./RoleCreateForm";
    export default {
        name: "BaseRoleCreate",
        components: {RoleCreateForm, CollapsibleSidebar},
        data() {
            return {
                show: false,
            }
        },
        props: {},
        computed: {},
        methods: {
            back() {
                this.$router.push({name: 'role-management'})
            }
        },
        mounted() {
            this.show = true; // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
