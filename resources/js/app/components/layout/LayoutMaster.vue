<template>
    <v-app :dark="dark">
        <logged-in-as-alert/>

        <sidebar v-if="!disableSidebar" v-model="showSidebar"></sidebar>

        <navbar v-if="!disableSidebar" @toggled-sidebar="showSidebar=!showSidebar"></navbar>

        <v-main>
            <slot></slot>
        </v-main>
    </v-app>

</template>

<script>
    import Sidebar from "./sidebar/BaseSidebar";
    import Navbar from "./NavBar";
    import LoggedInAsAlert from "../../../partials/LoggedInAsAlert";

    export default {
        name: "layout-master",
        components: {LoggedInAsAlert, Navbar, Sidebar},
        data() {
            return {
                dark: false,
                showSidebar: null,
            }
        },
        props: {
            disableSidebar: {
                type: Boolean,
                default: false
            }
        },
        methods: {

        },
        mounted() {


        },
    }

</script>

<style scoped>

</style>
