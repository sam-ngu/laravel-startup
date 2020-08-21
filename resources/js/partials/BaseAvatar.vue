<template>
    <v-avatar :size="size">
        <img :src="avatar" alt="NA" style="cursor: pointer">
    </v-avatar>
</template>

<script>
    export default {
        name: "BaseAvatar",
        data() {
            return {}
        },
        props: {
            size: {
                type: Number,
                default: 75
            },
            name: {
                type: String,
                required: true
            },
            avatarLocation: {
                type: String,
                default: null,
            }
        },
        computed: {

            avatar(){
                return this.avatarLocation ? this.avatarLocation : this.generateAvatarCdn(this.size, this.name);
            }
        },
        methods: {
            generateAvatarCdn(size="50", identifier){
                // return "https://api.adorable.io/avatars/" + String(size)+ "/" + String(identifier) + ".png"
                return "https://ui-avatars.com/api/?size=" + String(size)+ "&name=" + String(identifier)
            },
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
