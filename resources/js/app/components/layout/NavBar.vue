<template>
    <v-app-bar
            app
            clipped-left
            dense
            fixed
            color="light-blue darken-2">
        <v-app-bar-nav-icon @click="toggleSideBar"></v-app-bar-nav-icon>

        <v-toolbar-title > <router-link class="white--text" style="text-decoration: none;" :to="{name: 'home'}">Boilerplate</router-link></v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn @click="toggleDarkMode" icon>
            <v-icon :color="darkModeIconColor">brightness_3</v-icon>
        </v-btn>

        <v-menu offset-y left>
            <template v-slot:activator="{on}">
                <div v-on="on">
                    <v-btn
                        icon
                    >
                        <v-icon>more_vert</v-icon>
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

    export default {
        name: "navbar",
        components: {},
        data() {
            return {
                dark: false,

                menuItems: [
                    {title: 'Logout', action: this.logout}
                ]
            }
        },
        props: {},
        computed: {
            darkModeIconColor(){
                return this.dark ? "white" : null
            }
        },
        methods: {
            toggleDarkMode(){
                this.dark = !this.dark;
                // EventBus.$emit('toggled-dark')

            },
            toggleSideBar(){
                // EventBus.$emit('toggled-sidebar')
            },
            logout(){
                window.location.href = '/logout';
            },


        },
        mounted() {

        },
    }


</script>

<style scoped>

</style>
