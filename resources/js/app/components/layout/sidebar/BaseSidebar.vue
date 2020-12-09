<template>
    <v-navigation-drawer
            app
            hide-overlay
            clipped
            fixed
            :value="showSidebar"
            floating
            @input="($event)=>{ setSidebarOpened($event) }"
    >
        <v-list inset>

            <sidebar-list-tile to="/" title="Dashboard" icon="mdi-home"/>

            <sidebar-list-tile :to="{name: 'user-profile'}" title="My Profile" icon="mdi-account-circle"/>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import SidebarListTile from "./SidebarListTile";
    import {useAppStateStore} from "../../../../hook/app-state-store";

    const {isSidebarOpened} = useAppStateStore();

    export default {
        name: "sidebar",
        components: {SidebarListTile},
        setup(){
            function setSidebarOpened(value){
                isSidebarOpened.value = value;
            }
            return {
                setSidebarOpened,
                showSidebar: isSidebarOpened
            }
        },
    }


</script>

<style scoped>

</style>
