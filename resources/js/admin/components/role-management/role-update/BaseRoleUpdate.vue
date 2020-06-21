<template>
    <collapsible-sidebar v-model="show" @dismiss-sidebar="back">
        <template slot="header">
            {{ roleName }}
        </template>

        <template slot="content">
            <role-update-form :data="data" @role-updated="back"></role-update-form>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../partials/CollapsibleSidebar";
    import RoleUpdateForm from "./RoleUpdateForm";

    import StringHelper from "../../../../utils/StringHelper";


    export default {
        name: "BaseRoleUpdate",
        components: {RoleUpdateForm, CollapsibleSidebar},
        data() {
            return {

                show: false,

            }
        },
        computed: {
            roleName(){
                return StringHelper.titleCase(this.data.name)
            }
        },
        props: {
            data: {
                type: Object,
                required: true,
            }
        },
        methods: {
            back() {
                this.$router.push({name: 'role-management'})
            },
        },
        mounted() {
            this.show = true;  // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
