<template>
    <v-navigation-drawer
            app
            hide-overlay
            disable-route-watcher
            width="300"
            clipped
            fixed
            v-model="showSidebar"
            floating
    >
        <v-list inset>
            <sidebar-list-tile :to="{name: 'home'}" title="Dashboard" icon="mdi-home"/>

            <sidebar-list-tile v-for="admin in admins()" :key="admin.id" :to="admin.to" :title="admin.name" :icon="admin.icon"/>

<!--            <v-list-group-->
<!--                    v-if="session.user.roles_label === 'Administrator'"-->
<!--                    prepend-icon="account_circle"-->
<!--                    value="true"-->
<!--            >-->
<!--                <template v-slot:activator>-->

<!--                    <v-list-item >-->
<!--                        <v-list-item-title>Users</v-list-item-title>-->
<!--                    </v-list-item>-->
<!--                </template>-->

<!--                <v-list-group-->
<!--                        no-action-->
<!--                        sub-group-->
<!--                        value="true"-->
<!--                >-->
<!--                    <template v-slot:activator>-->

<!--                        <v-list-item>-->
<!--                            <v-list-item-title>Access</v-list-item-title>-->
<!--                        </v-list-item>-->
<!--                    </template>-->

<!--                    <sidebar-list-tile-->
<!--                        v-for="(admin, i) in admins"-->
<!--                        :key="i"-->
<!--                        :to="admin.to"-->
<!--                        :icon="admin.icon"-->
<!--                        :title="admin.name"-->
<!--                    />-->

<!--                </v-list-group>-->
<!--            </v-list-group>-->

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

    export default {
        name: "BaseSidebar",
        components: {SidebarListTile},
        data() {
            return {

            }
        },
        methods: {
            matchRoute(to){
                return this.$router.resolve(to).resolved.matched[0];
            },
            /** This is a workaround to solve the issue where resource table is not rendered,
             * (vue router reuse the component, and the mounted script on the base resource component is not rerun)
             * Awaiting fix on Vue 3 -- ability to dynamically add/remove route
             *  */
            resolveDestination(resourceName){
                const table = {name: resourceName + '-table'};
                const management = {name: resourceName + '-management'};
                let matched = this.matchRoute(table);
                if(matched){
                    return table;
                }else {
                    return management;
                }

            },
            admins(){
                return [
                    {
                        name: "User Management",
                        icon: "mdi-people_outline",
                        to: this.resolveDestination('user')
                    },
                    {
                        name: "Role Management",
                        icon: "mdi-settings",
                        to: this.resolveDestination('role')
                    },
                ]
            },
        },

        computed:{
            isAdmin(){
                return this.session.user?.roles?.findIndex((role) => role.name === 'administrator') !== -1
            },
            session(){
                return this.$store.getters['auth/session']
            },
            showSidebar: {
                get(){
                    return this.$store.getters['app/isSidebarOpened']
                },
                set(value){
                    this.$store.commit('app/setSidebar', value);
                }
            }

        },

    }


</script>

<style scoped>

</style>
