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
        <v-list>

            <sidebar-list-tile to="/" title="Dashboard" icon="mdi-home"/>

            <sidebar-list-tile :to="{name: 'user-profile'}" title="My Profile" icon="mdi-account-circle"/>

        </v-list>

        <template v-slot:append>
            <v-list nav>

                <v-list-item>
                    <v-list-item-icon>
                        <base-avatar :size="45" :name="user.name"/>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-btn @click="logout" text color="primary">Logout
                            <v-icon right>mdi-exit-to-app</v-icon>
                        </v-btn>
                    </v-list-item-content>
                </v-list-item>

            </v-list>
        </template>

    </v-navigation-drawer>
</template>

<script>
import SidebarListTile from "./SidebarListTile";
import {useAppStateStore} from "../../../store/app-state-store";
import BaseAvatar from "../../../../partials/BaseAvatar";
import {computed} from "@vue/composition-api";
import {useAuthStore} from "../../../store/auth-store";
import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

const {isSidebarOpened} = useAppStateStore();
const {getUser} = useAuthStore();

export default {
    name: "sidebar",
    components: {BaseAvatar, SidebarListTile},
    setup() {
        function setSidebarOpened(value) {
            isSidebarOpened.value = value;
        }

        const user = computed(() => {
            return getUser();
        });

        const logout = function () {
            axios.post('/logout')
                .then(() => {
                    window.location.href = '/';
                })
                .catch(axiosErrorCallback)

        }
        return {
            logout,
            user,
            setSidebarOpened,
            showSidebar: isSidebarOpened
        }
    },
}


</script>

<style scoped>

</style>
