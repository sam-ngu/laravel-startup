<template>
    <v-app-bar
            app
            clipped-left
            dense
            fixed
            color="light-blue darken-2">
        <v-app-bar-nav-icon @click="toggleSideBar"></v-app-bar-nav-icon>

        <v-toolbar-title >
            <router-link class="white--text" style="text-decoration: none;" :to="{name: 'home'}">Boilerplate</router-link>
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn @click="toggleDarkMode" icon>
            <v-icon :color="darkModeIconColor">mdi-brightness-3</v-icon>
        </v-btn>

        <v-menu offset-y left>
            <template v-slot:activator="{on}">
                <div v-on="on">
                    <v-btn
                        icon
                    >
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </div>

            </template>
            <v-list>
                <v-list-item
                    v-for="(item, index) in menuItems"
                    :key="index"
                    @click="item.action.call()"
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </v-app-bar>
</template>

<script>
    import {useAppStateStore} from "../../store/app-state-store";

    const {isSidebarOpened} = useAppStateStore();

    export default {
        name: "navbar",
        components: {},
        data() {
            return {
                menuItems: [
                    {title: 'Logout', action: this.logout}
                ]
            }
        },
        props: {},
        computed: {
            darkModeIconColor(){
                return this.$vuetify.theme.dark ? "white" : null
            }
        },
        methods: {
            toggleDarkMode(){
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark
            },
            toggleSideBar(){
                isSidebarOpened.value = !isSidebarOpened.value;
            },
            logout(){
                axios.post('/logout')
                    .then(() => {
                        window.location.href = '/logout';
                    })
            },
        },

    }


</script>

<style scoped>

</style>
