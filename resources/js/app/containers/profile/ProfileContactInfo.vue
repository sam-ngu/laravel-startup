<template>
    <v-card>
        <v-card-title>
            <h1 class="title">Contact Info</h1>
        </v-card-title>

        <v-list two-line>

            <v-list-item
                @click="item.action.call()"
                :disabled="item.disabled"
                v-for="(item, index) in listItems"
                :key="index">

                <v-list-item-content>

                    <v-list-item-title >
                        <h4 class="text-uppercase" v-text="item.title"></h4>
                    </v-list-item-title>

                    <v-list-item-subtitle>
                        <h4 v-text="item.subtitle"></h4>
                    </v-list-item-subtitle>

                </v-list-item-content>

                <v-list-item-action>
                    <v-icon>{{item.actionIcon}}</v-icon>
                </v-list-item-action>

            </v-list-item>

        </v-list>
    </v-card>
</template>

<script>
    export default {
        name: "ProfileContactInfo",
        data() {
            return {}
        },
        props: {},
        computed: {
            listItems(){
                return [
                    {
                        title: "Email",
                        subtitle: this.user.email,
                        // actionIcon: "keyboard_arrow_right",
                        actionIcon: "",
                        action: this.editEmail,
                        disabled: true
                    },
                    {
                        title: "Phone",
                        subtitle: this.user.phone ? this.user.phone : "Not Available",
                        actionIcon: "mdi-chevron-right",
                        action: this.editPhone,
                        disabled: false,
                    },
                ]
            },
            user(){
                return this.$store.getters['auth/session'].user;
            }
        },
        methods: {
            editEmail(){

            },
            editPhone(){
                this.$router.push({
                    name: 'user-profile-phone'
                })
            }
        },
    }
</script>

<style scoped>

</style>
