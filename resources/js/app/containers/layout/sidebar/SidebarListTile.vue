<template>
    <v-list-item :href="href" :to="to" :color="color">
        <v-list-item-action>
            <v-icon>{{icon}}</v-icon>
        </v-list-item-action>
        <v-list-item-title v-text="title"></v-list-item-title>
    </v-list-item>
</template>

<script>
    export default {
        name: "SidebarListTile",
        props: {
            to: {
                default: undefined,
                type: Object | String,
            },
            href:{
                type: String,
                default: undefined,
            },
            icon: {
                default: '',
                type: String,
            },
            title: {
                required: true,
                type: String,
            },
            color: {
                default: '',
                type: String,
            }
        }
    }
</script>

<style scoped>

</style>
