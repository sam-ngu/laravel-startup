<template>
    <v-container>

        <!--basic info-->
        <profile-basic-info class="my-4"/>

        <profile-contact-info class="my-4"/>


    </v-container>
</template>

<script>
    import ProfileBasicInfo from "./ProfileBasicInfo";
    import ProfileContactInfo from "./ProfileContactInfo";
    export default {
        name: "BaseProfile",
        components: {ProfileContactInfo, ProfileBasicInfo},
    }
</script>

<style scoped>

</style>
