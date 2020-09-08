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

            <sidebar-list-tile v-for="admin in admins" :key="admin.id" :to="admin.to" :title="admin.name" :icon="admin.icon"/>

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
                v-if="session.user.roles_label === 'Administrator'"
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
                admins: [
                    {
                        name: "User Management",
                        icon: "mdi-people_outline",
                        to: {name: 'user-management'}
                    },
                    {
                        name: "Role Management",
                        icon: "mdi-settings",
                        to: {name: 'role-management'}
                    },
                ],
            }
        },
        computed:{
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
