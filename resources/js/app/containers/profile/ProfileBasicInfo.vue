<template>
    <v-card>
        <v-card-title>
            <h1 class="title">Profile</h1>
        </v-card-title>

        <v-list two-line>

            <v-list-item @click="editPhoto">
                <v-list-item-content>
                    <v-list-item-title >
                        <h4 class="text-uppercase" v-text="'photo'"></h4>
                    </v-list-item-title>

                </v-list-item-content>

                <v-list-item-action>

                    <base-avatar
                        :avatar-location="user.avatar_location"
                        :size="45"
                        :name="user.name || ''"></base-avatar>
                </v-list-item-action>

            </v-list-item>


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

        <profile-update-picture
            :picture="user.avatar_location"
            @close="() => {states.showUpdatePicture = false }"
            v-if="states.showUpdatePicture"/>

    </v-card>
</template>

<script>
    import BaseAvatar from "../../../partials/BaseAvatar";
    import ProfileUpdatePicture from "./basic-info/ProfileUpdatePicture";
    import {useAuthStore} from "../../store/auth-store";

    const {getUser} = useAuthStore();

    export default {
        name: "ProfileBasicInfo",
        components: {ProfileUpdatePicture, BaseAvatar},
        data() {
            return {
                states: {
                    showUpdatePicture: false,
                }
            }
        },
        props: {},
        computed: {
            listItems(){
                return [
                    {
                        title: "Name",
                        subtitle: this.user.name,
                        actionIcon: "mdi-chevron-right",
                        action: this.editName,
                        disabled: false,
                    },
                    {
                        title: "Password",
                        subtitle: this.user.password_changed_at ? 'Last updated at ' + this.user.password_changed_at: 'Never changed',
                        actionIcon: "mdi-chevron-right",
                        action: this.editPassword,
                        disabled: false
                    },
                ]
            },
            user(){
                return getUser();
            }
        },
        methods: {
            editPhoto(){
                this.states.showUpdatePicture = true;
            },
            editName(){
                this.$router.push({
                    name: 'user-profile-name',
                });
            },
            editPassword(){
                this.$router.push({
                    name: 'user-profile-password',
                });
            }
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
