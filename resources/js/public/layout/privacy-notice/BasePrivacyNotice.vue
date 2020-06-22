<template>
    <v-snackbar
        dark
        bottom
        left
        :timeout="-1"
        :value="states.show"
    >

        <div class="caption">
            This site uses cookies and other tracking technologies to assist with navigation and to analyse site usage. By
            using this website you agree to our use of cookies. For more information about our use of cookies, please see
            our <a class="blue--text text--lighten-3" href="/privacy-policy">Privacy Policy</a>. Your use of this site is also subject to our
            <a class="blue--text text--lighten-3"
               href="/terms-of-services">Terms of Use</a>.
            <v-btn class="mr-auto" dark text color="green lighten-3" right small @click="close">
                Got it
            </v-btn>
        </div>
    </v-snackbar>
</template>

<script>
    export default {
        name: "BasePrivacyNotice",
        data() {
            return {
                states: {
                    show: false,
                }
            }
        },
        computed: {
            storagePrivacyNoticeKeyName(){
                return 'has_read_privacy_notice';
            },
            hasRead() {
                return localStorage.getItem(this.storagePrivacyNoticeKeyName)
            }
        },
        methods: {
            close(){
                this.states.show = false;
                localStorage.setItem(this.storagePrivacyNoticeKeyName, true)
            }
        },
        mounted() {
            // check if user has closed the notice before
            this.states.show = !this.hasRead;

        },
    }
</script>

<style scoped>

</style>
