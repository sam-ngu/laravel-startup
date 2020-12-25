<template>
    <v-container>

        <!--basic info-->
        <profile-basic-info class="my-4"/>

        <profile-contact-info class="my-4"/>


        <profile-security class="my-4"/>


    </v-container>
</template>

<script>
    import ProfileBasicInfo from "./ProfileBasicInfo";
    import ProfileContactInfo from "./ProfileContactInfo";
    import ProfileSecurity from "./ProfileSecurity";
    export default {
        name: "BaseProfile",
        components: {ProfileSecurity, ProfileContactInfo, ProfileBasicInfo},
    }
</script>

<style scoped>

</style>
