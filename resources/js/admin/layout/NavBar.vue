<template>
    <v-app-bar
            app
            clipped-left
            dense
            fixed
            color="red darken-4">
        <v-app-bar-nav-icon @click="openSidebar"></v-app-bar-nav-icon>

        <v-toolbar-title > <router-link class="white--text" style="text-decoration: none;" :to="{name: 'home'}">Startup</router-link></v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-apps</v-icon>
        </v-btn>

        <v-btn @click="toggleDarkMode" icon>
            <v-icon :color="darkModeIconColor">mdi-brightness-3</v-icon>
        </v-btn>

        <v-menu offset-y left>
            <template v-slot:activator="{on: menu}">

                <div v-on="{...menu}">

                    <v-btn icon>
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

    export default {
        name: "navbar",
        components: {},
        data() {
            return {
                menuItems: [
                    {title: 'Control', action: this.control},
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
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark;

            },
            openSidebar(){
                this.$store.commit('app/setSidebar', true);
            },
            logout(){
                window.location.href = '/logout';
            },
            control(){
                this.$router.push({
                    name: 'control',
                })
            }

        },
        mounted() {

        },
    }


</script>

<style scoped>

</style>
