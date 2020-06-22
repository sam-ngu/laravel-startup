<template>

    <layout-master>

        <v-container>
            <v-row justify="center">
                <h1>INSERT LOGO HERE</h1>
<!--                <v-img max-width="400" src="/storage/img/logo.svg"></v-img>-->
<!--                <login-svg title="Please Login"></login-svg>-->
            </v-row>

            <v-row justify="center">

                <registration-form :enable-recaptcha="Boolean(enableCaptcha)" :recaptcha-key="captchaKey" />
            </v-row>

            <slot name="socialite"></slot>

        </v-container>

    </layout-master>


</template>


<script>
    import RegistrationForm from "./auth/registration/RegistrationForm";
    import LayoutMaster from "./layout/LayoutMaster";
    export default {
        name: "BaseRegistration",
        components: {LayoutMaster, RegistrationForm},
        props: {
            captchaKey: {
                type: String,
            },
            enableCaptcha: {
                required: true
            }
        }
    }
</script>

<style scoped>

</style>
