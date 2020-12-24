<template>
    <v-navigation-drawer
            app
            hide-overlay
            width="300"
            clipped
            fixed
            :value="isSidebarOpened"
            @input="($event)=>{ setSidebarOpened($event) }"
            floating
    >
        <v-list inset>
            <sidebar-list-tile :to="{name: 'home'}" title="Dashboard" icon="mdi-home"/>

            <sidebar-list-tile v-for="admin in admins()" :key="admin.id" :to="admin.to" :title="admin.name" :icon="admin.icon"/>

            <v-list-item
                v-if="isAdmin"
                href="/admin/log-viewer">
                <v-list-item-action>
                    <v-icon>mdi-event_note</v-icon>
                </v-list-item-action>
                <v-list-item-title>Log Viewer</v-list-item-title>
            </v-list-item>

        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import SidebarListTile from "./SidebarListTile";
    import { useAppStateStore } from "../../store/app-state-store";
    import { useAuthStore } from "../../store/auth-store";
    import {computed} from '@vue/composition-api';
    import router from "../../routes/routes";

    const { isSidebarOpened, setSidebarOpened } = useAppStateStore();
    const { getUser } = useAuthStore();
    export default {
        name: "BaseSidebar",
        components: {SidebarListTile},
        setup(){

            function matchRoute(to){
                return router.resolve(to).resolved.matched[0];
            }
            /** This is a workaround to solve the issue where resource table is not rendered,
             * (vue router reuse the component, and the mounted script on the base resource component is not rerun)
             * Awaiting fix on Vue 3 -- ability to dynamically add/remove route
             *  */
            function resolveDestination(resourceName){
                const table = {name: resourceName + '-table'};
                const management = {name: resourceName + '-management'};
                let matched = matchRoute(table);
                if(matched){
                    return table;
                }else {
                    return management;
                }
            }
            function admins(){
                return [
                    {
                        name: "User Management",
                        icon: "mdi-people_outline",
                        to: resolveDestination('user')
                    },
                    {
                        name: "Role Management",
                        icon: "mdi-settings",
                        to: resolveDestination('role')
                    },
                ]
            }

            const isAdmin = computed(() => {
                return getUser().roles?.findIndex((role) => role.name === 'administrator') !== -1
            });

            return {
                isSidebarOpened,
                admins,
                setSidebarOpened,
                isAdmin,
            }
        },
    }

</script>

<style scoped>

</style>
