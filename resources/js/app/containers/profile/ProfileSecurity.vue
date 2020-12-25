<template>

    <v-card>
        <v-card-title>
            <h1 class="title">Security</h1>
        </v-card-title>

        <v-list two-line>

            <v-list-item
                @click="item.action.call()"
                :disabled="item.disabled"
                v-for="(item, index) in listItems"
                :key="index">

                <v-list-item-content>

                    <v-list-item-title>
                        <h4 class="text-uppercase" v-text="item.title"></h4>
                    </v-list-item-title>

                    <v-list-item-subtitle>
                        <h4 v-text="item.subtitle"></h4>
                    </v-list-item-subtitle>

                </v-list-item-content>

                <v-list-item-action>
                    <v-icon>{{ item.actionIcon }}</v-icon>
                </v-list-item-action>

            </v-list-item>

        </v-list>
    </v-card>

</template>

<script>
import {useAuthStore} from "../../store/auth-store";

const { getUser } = useAuthStore();

export default {
    name: 'ProfileSecurity',
    data() {
        return {
        }
    },
    props: {},
    computed: {
        user(){
            return getUser();
        },
        listItems(){
            return [
                {
                    title: "2 Factor Authentication",
                    subtitle: this.user?.two_fa_enabled ? 'Enabled' : 'Disabled',
                    actionIcon: "mdi-chevron-right",
                    action: this.edit2Fa,
                    disabled: false
                },
            ]
        }
    },
    methods: {
        edit2Fa(){
            this.$router.push({
                name: 'user-profile-2fa'
            })
        }

    },
    mounted() {

    },
}
</script>

<style scoped lang="scss">

</style>
