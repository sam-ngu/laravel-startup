<template>
    <v-alert
        v-if="displayLogInAsAlert()"
        class="logged-in-as-alert"
        :value="true"
        color="purple"
        icon="info"
        outlined
    >
        You are currently logged in as {{ session.user.first_name + ' ' + session.user.last_name }}.
        <a href="/logout-as">Re-Login as {{session.session.admin_user_name}}</a>.
    </v-alert>
</template>

<script>

    export default {
        name: "LoggedInAsAlert",
        data() {
            return {
            }
        },
        props: {},
        computed: {
            session(){
                return this.$store.getters['auth/session'];
            }
        },
        methods: {
            displayLogInAsAlert(){
                let session = this.session;
                return !_.isEmpty(session.user) && _.isNumber(session.session.admin_user_id) && _.isNumber(session.session.temp_user_id);
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>
    .logged-in-as-alert {
        bottom: 0px;
        right: 0px;
        position: absolute;
        z-index: 99;
    }
</style>
