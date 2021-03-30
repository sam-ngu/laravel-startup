<template>
    <v-app>
        <logged-in-as-alert/>

        <sidebar v-if="!disableSidebar"></sidebar>

        <navbar v-if="!disableSidebar" ></navbar>

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

        props: {
            disableSidebar: {
                type: Boolean,
                default: false
            }
        },
    }

</script>

<style scoped>

</style>
