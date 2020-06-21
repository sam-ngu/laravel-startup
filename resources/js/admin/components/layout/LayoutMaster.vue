<template>
    <div>
        <v-app :dark="dark" v-if="messageBus.isReady()">

            <logged-in-as-alert/>

            <sidebar v-if="!disableSidebar" v-model="showSidebar"></sidebar>

            <navbar v-if="!disableSidebar" @toggled-sidebar="showSidebar=!showSidebar"></navbar>

            <v-content>
                <slot></slot>
            </v-content>
        </v-app>

        <loading-eclipse v-else></loading-eclipse>
    </div>

</template>

<script>
    import Sidebar from "./sidebar/BaseSidebar";
    import Navbar from "./NavBar";
    import {EventBus} from "../../../utils/event-bus";
    import {MessageBus} from "../../../utils/MessageBus";
    import LoggedInAsAlert from "../../../partials/LoggedInAsAlert";
    import LoadingEclipse from "../../../partials/LoadingEclipse";


    export default {
        name: "layout-master",
        components: {LoadingEclipse, LoggedInAsAlert, Navbar, Sidebar},
        data() {
            return {
                dark: false,
                showSidebar: null,
                messageBus: MessageBus,
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
            EventBus.$on('toggled-dark', function () {
                this.dark = !this.dark;
            }.bind(this));

            EventBus.$on('toggled-sidebar', function () {
                this.showSidebar = !this.showSidebar;
            }.bind(this))
        },
    }

</script>

<style scoped>

</style>
