<template>
    <collapsible-sidebar v-model="show" @dismiss-sidebar="back">
        <template slot="header">
            {{data.name}}
        </template>

        <template slot="content">
            <user-update-form :data="data" @user-updated="back"/>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../partials/CollapsibleSidebar";
    import UserUpdateForm from "./UserUpdateForm";

    export default {
        name: "BaseUserUpdate",
        components: {UserUpdateForm, CollapsibleSidebar},
        data() {
            return {
                show: false,
            }

        },
        props: {
            data: {
                type: Object,
                required: true,
            }
        },
        computed: {},
        methods: {

            back() {
                this.$router.push({name: 'user-management'})
            }
        },
        mounted() {
            this.show = true;  // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
