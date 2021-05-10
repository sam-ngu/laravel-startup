<template>
    <v-footer
        height="auto"
        color="black lighten-1"
    >
        <v-container>
            <v-row
                justify="center"
                wrap
            >
                <v-btn
                    v-for="(item, index) in links"
                    :key="index"
                    color="white"
                    text
                    rounded
                    :href="item.link"
                >
                    {{ item.title }}
                </v-btn>

            </v-row>

            <v-divider></v-divider>

            <v-row justify="center">
                <v-col>
                    <v-btn href="https://www.facebook.com/" icon dark>
                        <v-icon>fab fa-facebook-square</v-icon>
                    </v-btn>
                </v-col>

                <v-col
                    black
                    lighten-2
                    py-4
                    text-center
                    white--text
                    xs12
                    class="text-center"
                >
                    {{year}} — <strong>Boilerplate</strong>. All rights reserved.
                </v-col>
            </v-row>
        </v-container>


    </v-footer>
</template>

<script>
    export default {
        name: "BaseFooter",
        data() {
            return {
                links: [
                    {
                        title: "Home",
                        link: "/"
                    },
                    // {
                    //     title: "About Us",
                    //     link: "#"
                    // },
                    {
                        title: "Privacy Policy",
                        link: "/privacy-policy"
                    },
                    {
                        title: "Terms of Use",
                        link: "terms-of-services"
                    },
                    {
                        title: "Contact Us",
                        link: "/contact"
                    },
                    {
                        title: "Site Map",
                        link: "/sitemap.xml"
                    },


                ]
            }
        },
        computed: {
            year(){
                return '\u00A9' + (new Date()).getFullYear();
            }
        }
    }
</script>

<style scoped>

</style>
