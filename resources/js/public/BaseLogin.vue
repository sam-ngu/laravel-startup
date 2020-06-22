<template>

    <layout-master>

        <v-container>

            <v-row justify="center">
                <h1>INSERT LOGO HERE</h1>
<!--                <v-img max-width="400" src="/storage/img/logo.svg"></v-img>-->
            </v-row>

            <v-row justify="center">

                <base-login-form style="width: 400px"/>

            </v-row>


            <slot name="socialite"></slot>


        </v-container>

    </layout-master>
</template>

<script>
    import LayoutMaster from "./layout/LayoutMaster";
    import BaseLoginForm from "./auth/login/LoginForm";
    export default {
        name: "BaseLogin",
        components: {BaseLoginForm, LayoutMaster},
        data() {
            return {}
        },
        props: {},
        computed: {},
        methods: {},
        mounted() {

        },
    }
</script>

<style scoped>

</style>
