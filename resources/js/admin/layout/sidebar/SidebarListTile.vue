<template>
    <v-list-item :to="to">
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
                default: "#",
                type: Object | String,
            },
            icon: {
                default: 'home',
                type: String,
            },
            title: {
                required: true,
                type: String,
            }
        }
    }
</script>

<style scoped>

</style>
