<template>
    <v-container>
        <base-table-layout></base-table-layout>
        <router-view></router-view>
    </v-container>
</template>

<script>
    import BaseTableLayout from "../components/user-management/user-table/BaseTableLayout";

    export default {
        name: "BaseUserManagement",
        components: {BaseTableLayout},
    }
</script>

<style scoped>

</style>
