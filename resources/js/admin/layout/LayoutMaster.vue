<template>
    <div>
        <v-app :dark="dark">

            <logged-in-as-alert/>

            <base-sidebar></base-sidebar>

            <navbar @toggled-sidebar="showSidebar=!showSidebar"></navbar>

            <v-main>
                <slot></slot>
            </v-main>
        </v-app>

    </div>

</template>

<script>
import BaseSidebar from "./sidebar/BaseSidebar";
import Navbar from "./NavBar";
import LoggedInAsAlert from "../../partials/LoggedInAsAlert";
import LoadingEclipse from "../../partials/LoadingEclipse";


export default {
    name: "layout-master",
    components: {LoadingEclipse, LoggedInAsAlert, Navbar, BaseSidebar},
    data() {
        return {
            dark: false,
        }
    },
    computed: {},
    props: {},
    methods: {},
    mounted() {
        // check if session is passed
        if (this.$attrs.session) {
            this.$store.commit('auth/setSession', JSON.parse(this.$attrs.session))
        }

    },
}

</script>

<style scoped>

</style>
