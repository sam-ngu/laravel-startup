<template>
    <div>
        <v-app>
            <navbar :initial-colour="navbarInitialColour"></navbar>

            <v-main>
                <slot></slot>
            </v-main>
            <base-footer></base-footer>

            <base-privacy-notice/>

            <logged-in-as-alert/>
        </v-app>

    </div>


</template>

<script>
    import Navbar from "./navbar/NavBar";
    import BaseFooter from "./footer/BaseFooter";
    import BasePrivacyNotice from "./privacy-notice/BasePrivacyNotice";
    import LoggedInAsAlert from "../../partials/LoggedInAsAlert";

    export default {
        name: "layout-master",
        components: {LoggedInAsAlert, BasePrivacyNotice, BaseFooter, Navbar},
        data() {
            return {
            }
        },
        props: {
            navbarInitialColour: {
                default: "grey darken-3",
                type: String,
            }
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
