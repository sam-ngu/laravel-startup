<template>
    <div>
        <v-app :dark="dark">

            <logged-in-as-alert/>

            <sidebar v-if="!disableSidebar" v-model="showSidebar"></sidebar>

            <navbar v-if="!disableSidebar" @toggled-sidebar="showSidebar=!showSidebar"></navbar>

            <v-content>
                <slot></slot>
            </v-content>
        </v-app>

    </div>

</template>

<script>
    import Sidebar from "./sidebar/BaseSidebar";
    import Navbar from "./NavBar";
    import LoggedInAsAlert from "../../../partials/LoggedInAsAlert";
    import LoadingEclipse from "../../../partials/LoadingEclipse";


    export default {
        name: "layout-master",
        components: {LoadingEclipse, LoggedInAsAlert, Navbar, Sidebar},
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
            // check if session is passed
            if(this.$attrs.session){
                this.$store.commit('auth/setSession', JSON.parse(this.$attrs.session))
            }

        },
    }

</script>

<style scoped>

</style>
