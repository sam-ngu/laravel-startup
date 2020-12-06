<template>
    <v-container>
        <v-row>
            <v-col>
                <v-toolbar flat>
                    <v-toolbar-title>Role Management</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <button-tooltip
                        icon="add"
                        tooltip="Add new role"
                        :to="{name: 'role-create'}"
                    />
                </v-toolbar>
            </v-col>
        </v-row>

        <v-row>
            <v-col>
                <v-data-table
                    :headers="headers"
                    :items="data.roles"
                    :items-per-page="pageSize"
                    :loading="states.isLoading"
                    hide-default-footer
                    class="elevation-3"
                >
                    <template v-slot:item="props">
                        <tr>
                            <td class="px-2 text-left">
                                <router-link
                                    v-if="props.item.name!=='administrator'"
                                    :to="{
                                        name: 'role-show',
                                        params: {
                                            id: props.item.id,
                                            data: props.item,
                                            show: true,
                                        }
                                }">
                                    {{ titleCase(props.item.name) }}
                                </router-link>
                                <div v-else>{{titleCase(props.item.name)}}</div>
                            </td>
                            <td class="px-2 text-left">
                                <!--if permission not empty-->
                                <!--for each permissions, list the name-->
                                <div v-if="!isEmpty(props.item.permission)">
                                    <span v-for="(item, index) in props.item.permission" :key="index">
                                        {{titleCase(item.name)}}
                                    </span>
                                </div>
                                <div v-else v-text="'N/A'"></div>
                            </td>
                            <td class="px-2 text-left">{{ String(props.item.user_num) }}</td>
                            <td class="px-2 justify-center layout px-0">
                                <v-row align-center justify-center fill-height>

                                    <button-tooltip
                                        v-if="props.item.name!=='administrator'"
                                        tooltip="Delete"
                                        icon="delete"
                                        small
                                        @click="deleteItem(props.item)"
                                    />
                                    <div v-else>N/A</div>
                                </v-row>
                            </td>
                        </tr>

                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <v-row column>
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
                    @input="fetchRoles"
                ></v-pagination>
            </div>

            <div>
                <v-select
                    v-if="!states.isLoading"
                    solo
                    messages="Items per page"
                    :items="[10,25,50,100,200,500,1000]"
                    v-model="pageSize"
                    @change="fetchRoles"
                    label="Items per page"
                    style="width: 150px;"
                />
            </div>
        </v-row>

    </v-container>
</template>

<script>
    import StringHelper from "../../../utils/StringHelper";
    import ButtonTooltip from "../../../partials/ButtonTooltip";
    import {swalLoader} from "../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../utils/swal/AxiosHelper";

    export default {
        name: "RoleTable",
        components: {ButtonTooltip},
        data() {
            return {
                states: {
                    isLoading: false,  // if true then show loader
                },
                apiMeta: {},
                pageSize: 200,

                data: {
                    roles: [],  // hold roles info from api call
                },

                headers: [
                    {
                        text: 'Role',
                        align: 'left',
                        sortable: false,
                        value: 'role',
                        class: "px-2"
                    },
                    {text: 'Permissions', value: 'permissions', sortable: false, class: "px-2"},
                    {text: 'Number of Users', value: 'user_num', sortable: false, class: "px-2"},
                    {text: 'Actions', value: 'action', sortable: false, align: "center", class: "px-2"},
                ],

            }
        },
        methods: {
            titleCase(string){
                return StringHelper(string);
            },
            deleteItem(item) {
                swalLoader();
                this.states.isLoading = true;
                let uri = '/api/v1/roles/' + String(item.id);
                axios.delete(uri)
                    .then(function (response) {
                        swal.close();
                        this.states.isLoading = false;
                        this.reloadTable();

                    }.bind(this))
                    .catch(axiosErrorCallback);
            },
            async fetchRoles() {
                await this.$nextTick();
                swalLoader();
                this.states.isLoading = true;
                let uri;
                uri = `/api/v1/roles?page=${this.apiMeta.current_page}&page_size=${this.pageSize}`;

                //fetch data / call api
                return axios.get(uri)
                    .then(function (response) {
                        swal.close();
                        this.data.roles = response.data.data;
                        this.states.isLoading = false;
                        this.apiMeta = response.data.meta;

                    }.bind(this))
                    .catch(axiosErrorCallback);
            },
            isEmpty(array) {
                return _.isEmpty(array);
            },
            reloadTable() {
                this.fetchRoles()
            }
        },
        mounted() {
            // call api -- grab roles deets
            this.fetchRoles();

            // EventBus.$on("table-reload-required", function () {
            //     this.reloadTable()
            // }.bind(this))
        },
    }
</script>

<style scoped>
    .no-underline:hover {
        text-decoration: none;
    }
</style>
