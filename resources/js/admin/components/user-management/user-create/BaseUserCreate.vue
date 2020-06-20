<template>
    <collapsible-sidebar v-model="show" @dismiss-sidebar="back">
        <template slot="header">
            <h1>Create User</h1>
        </template>

        <template slot="content">
            <v-container>
                <v-row >
                    <v-col>
                        <user-create-form @user-created="back"/>

                    </v-col>
                </v-row>
            </v-container>
        </template>

    </collapsible-sidebar>
</template>

<script>
    import CollapsibleSidebar from "../../../../utils/CollapsibleSidebar";
    import UserCreateForm from "./UserCreateForm";
    export default {
        name: "BaseUserCreate",
        components: {UserCreateForm, CollapsibleSidebar},
        data() {
            return {
                show: false,
            }
        },
        props: {},
        computed: {},
        methods: {
            back() {
                this.$router.push({name: 'user-management'})
            }
        },
        mounted() {
            this.show = true; // trigger fade effect
        },
    }
</script>

<style scoped>

</style>
