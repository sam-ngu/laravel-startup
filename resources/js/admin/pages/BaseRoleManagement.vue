<template>
    <v-container>
        <role-table/>
        <router-view/>

    </v-container>
</template>

<script>
    import RoleTable from "../components/role-management/RoleTable";

    export default {
        name: "BaseRoleManagement",
        components: {RoleTable},
    }
</script>

<style scoped>

</style>
