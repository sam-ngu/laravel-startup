<script>
    import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";

    export default {
        name: "PermissionMixin",
        data() {
            return {
                permissions: [],
                states: {
                    isLoading: false,
                }
            }
        },
        methods: {
            fetchPermissions(){
                let uri = "/api/v1/permissions";
                this.states.isLoading = true;

                //fetch data / call api
                return axios.get(uri)
                    .then(function (response) {
                        swal.close();
                        this.permissions = response.data.data;
                        this.states.isLoading = false;
                        // this.apiMeta = response.data.meta;

                    }.bind(this)).catch(axiosErrorCallback);
            }
        },
        mounted() {
            this.fetchPermissions()
        },
    }
</script>

<style scoped>

</style>
