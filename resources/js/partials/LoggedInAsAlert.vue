<template>
    <v-alert
        v-if="displayLogInAsAlert"
        class="logged-in-as-alert"
        :value="true"
        type="info"
        outlined
    >
        You are currently logged in as {{ session.user.name }}.
        <a class="accent--text" href="/api/v1/user-logout-as">Re-Login as {{session.admin_user_name}}</a>.
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
            },
            displayLogInAsAlert(){
                let session = this.session;
                return !_.isEmpty(session.user) && _.isNumber(session.admin_user_id) && _.isNumber(session.temp_user_id);
            }
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
