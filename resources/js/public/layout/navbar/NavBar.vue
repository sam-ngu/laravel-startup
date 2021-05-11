<template>

    <v-app-bar
        class="toolbar"
        app
        dense
        :dark="dark"
        :color="colour"
    >

<!--        <v-btn icon v-slot:activator="{on}"> <v-icon>mdi-menu</v-icon> </v-btn>-->

        <v-toolbar-title><span><a class="red--text darken-3" href="/">{{appName}}</a></span></v-toolbar-title>

        <v-spacer></v-spacer>

        <v-toolbar-items v-if="!viewport_xs" >

            <v-btn v-for="(item, index) in menuItems" :href="item.url" :key="index" color="white" text class="mx-1">
                {{item.title}}
            </v-btn>

            <v-btn class="my-auto" v-if="!isLoggedIn()" href="/login" color="success"  outlined style="max-height: 75%">
                Login
            </v-btn>

            <logged-in-items v-else/>
        </v-toolbar-items>

        <v-menu dark v-else bottom left width="150" >

            <template v-slot:activator="{on}">

                <v-app-bar-nav-icon v-on="on"></v-app-bar-nav-icon>

            </template>

            <v-card>
                <logged-in-items v-if="isLoggedIn()" />
                <v-list>
                    <v-list-item v-if="!isLoggedIn()" href="/login">Login</v-list-item>

                    <v-list-item v-for="(item, index) in menuItems" :href="item.url" :key="index">
                        <v-list-item-content>{{item.title}}</v-list-item-content>
                    </v-list-item>
                </v-list>

            </v-card>

        </v-menu>

    </v-app-bar>
</template>

<script>
    import LoggedInItems from "./LoggedInItems";
    import ViewportHelperMixin from "../../../utils/mixins/ViewportHelperMixin";

    export default {
        name: "navbar",
        mixins: [ViewportHelperMixin],
        components: {LoggedInItems},
        data() {
            return {
                dark: true,
                colour: this.initialColour,
                menuItems: [
                    {title: 'FAQ', url: "/faq"},
                    {title: 'Contact', url: "/contact"}
                ]
            }
        },
        props: {
            initialColour: {  //colour of nav bar before scrolling or when at the top
                type: String,
                default: "grey darken-3"
            },
            scrolledColour: {
                type: String,
                default: "grey darken-3",
            }
        },
        computed: {
            appName(){
              return process.env.MIX_APP_NAME;
            }
        },
        methods: {

            isLoggedIn(){
                return !_.isEmpty(this.$store.getters['auth/session'].user);
            },
            changeColour(){
                let scrolled = window.scrollY !== 0;
                // this.dark = !scrolled;
                this.colour = scrolled ? this.scrolledColour : this.initialColour
            }
        },
        mounted() {
            window.addEventListener('scroll', this.changeColour)
        },
        destroyed(){ //prevent memory leak
            window.removeEventListener('scroll', this.changeColour)
        }
    }


</script>

<style scoped>
    .toolbar{
        width: 100%
    }
    a {
        text-decoration: none;
    }
    a:hover{
        text-decoration: none;
    }
</style>
