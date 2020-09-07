<template>
    <v-row align="center" justify="center" >

        <v-menu offset-y left>
            <template v-slot:activator="{on: menu}">
                <div v-on="{...menu}">
                    <button-tooltip
                        icon="more_vert"
                        tooltip="More"
                        small
                    />
                </div>
            </template>
            <v-list>
                <v-list-item
                    v-for="(item, index) in listItems"
                    :key="index"
                    :disabled="item.disabled"
                    @click="item.action.call()"
                    v-show="item.show"
                >
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>

        <button-tooltip
            @click="deleteItem"
            tooltip="Delete"
            small
            icon="delete"
        />
    </v-row>


</template>

<script>
    // import {MessageBus} from "../../../../utils/MessageBus";
    import ButtonTooltip from "../../../../partials/ButtonTooltip";
    import {swalConfirm, swalLoader, swalMessage} from "../../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

    export default {
        aname: "UserTableActions",
        components: {ButtonTooltip},
        data() {
            return {}
        },
        props: {
            user: {
                type: Object,
                required: true,
            },

        },
        computed: {
            listItems(){
                return [
                    {
                        title: "Log in as " + this.user.first_name + ' ' + this.user.last_name,
                        action: this.logInAsUser,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: !this.isDeleted,
                    },
                    {
                        title: 'Deactivate',
                        action: this.deactivate,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: this.isActive,
                    },
                    {
                        title: 'Reactivate',
                        action: this.reactivate,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: this.isDeactivated,
                    },
                    {
                        title: 'Restore',
                        action: this.restore,
                        disabled: MessageBus.getSession().user.id === this.user.id,
                        show: this.isDeleted,
                    },

                ]
            },
            isActive(){
                return this.user.active && !this.isDeleted;
            },
            isDeactivated(){
                return !this.isActive && !this.isDeleted;
            },
            isDeleted(){
                return this.user.deleted_at !== "";
            }


        },
        methods: {
            logInAsUser(){
                let uri = '/admin/auth/user/' + String(this.user.id) + '/login-as';
                // axios.get(uri)
                window.location.href = window.location.protocol + "//" + window.location.hostname + uri;
            },
            deactivate(){
                let uri = '/api/v1/users/' + String(this.user.id) + '/mark/0';
                this.callApi(uri);
            },
            reactivate(){
                let uri = '/api/v1/users/' + String(this.user.id) + '/mark/1';
                this.callApi(uri);
            },
            restore(){
                let uri = '/api/v1/users/' + String(this.user.id) + '/restore';
                this.callApi(uri);
            },
            callApi(uri, method = 'get'){
                swalLoader();
                axios({
                    method: method,
                    url: uri,
                }).then(function (response) {
                    swal.close();
                    // EventBus.$emit('table-reload-required');
                }).catch(axiosErrorCallback)
            },
            deleteItem(){
                let uri;

                swalConfirm("", function(){
                    swalLoader();

                    if(this.isActive || this.isDeactivated){
                        uri = '/api/v1/users/' + String(this.user.id);
                        this.callApi(uri, 'delete')
                    }
                    if(this.isDeleted){
                        uri = '/api/v1/users/' + String(this.user.id) + '/delete';
                        this.callApi(uri, 'get');
                    }
                }.bind(this));




            },
        },
        mounted() {

        },
    }
</script>

<style scoped>

</style>
