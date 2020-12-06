<template>
    <v-card>
        <!--photo-->
        <!--name-->
        <!--            birthday-->
        <!--password-->

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
                        <h5 class="text-uppercase" v-text="item.title"></h5>
                    </v-list-item-title>

                    <v-list-item-subtitle>
                        <h5 v-text="item.subtitle"></h5>
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
    import {MessageBus} from "../../../../utils/message-bus";

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
                        actionIcon: "keyboard_arrow_right",
                        action: this.editPhone,
                        disabled: false,
                    },
                ]
            },
            user(){
                return MessageBus.getSession().user;
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
