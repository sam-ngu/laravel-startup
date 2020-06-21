<template>
    <v-container>
        <v-row>
            <v-col>
                <v-toolbar flat>
                    <v-toolbar-title>User Management</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <button-tooltip
                        tooltip="Add new user"
                        icon="add"
                        :to="{
                            name: 'user-create',
                        }"

                    />
                </v-toolbar>
            </v-col>
        </v-row>

        <v-row> <!--search bar-->
            <v-col>
                <v-text-field
                    class="pl-2 pr-12"
                    append-icon="fas fa-search"
                    label="Search"
                    v-model="searchKeywords"></v-text-field>
            </v-col>
        </v-row>

        <v-row>
            <v-col>

                <v-tabs fixed-tabs
                        v-model="tab"
                        @change="switchTab"
                >
                    <v-tab
                        v-for="(item, index) in tabList"
                        :key="index"
                    >
                        {{titleCase(item.title)}}
                    </v-tab>
                </v-tabs>

                <user-table
                    :data="data.users"
                    :is-loading="states.isLoading"
                ></user-table>
            </v-col>
        </v-row>

        <v-row >
            <v-col>

                <div class="pt-4">
                    <h5>Total: {{apiMeta.total}}</h5>
                </div>
            </v-col>
        </v-row>
        <v-divider></v-divider>
        <v-row justify="space-between">

            <div>
                <v-pagination
                    v-model="apiMeta.current_page"
                    round
                    :length="apiMeta.last_page"
                    total-visible="10"
                    @input="fetchUsers"
                ></v-pagination>
            </div>

            <div>
                <v-select
                    v-if="!states.isLoading"
                    solo
                    messages="Items per page"
                    :items="[10,25,50,100,200,500,1000]"
                    v-model="pageSize"
                    @change="fetchUsers"
                    label="Items per page"
                    style="width: 150px;"
                ></v-select>
            </div>
        </v-row>

    </v-container>
</template>

<script>
    import ButtonTooltip from "../../../../partials/ButtonTooltip";
    export default {
        name: "BaseCrud",
        components: {ButtonTooltip},
        data() {
            return {}
        },
        props: {},
        computed: {},
        methods: {},
        mounted() {

        },
    }
</script>

<style scoped>

</style>
