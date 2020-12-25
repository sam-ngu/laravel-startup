<script>
    import {swalConfirm, swalLoader, swalTimer} from "../../../utils/swal/SwalHelper";
    import {axiosErrorCallback} from "../../../utils/swal/AxiosHelper";

    export default {
        name: "ProfileUpdateMixin",
        components: {},
        data() {
            return {
                inputData: {
                    phone: null,
                    name: null,
                    last_name: null,
                    old_password: null,
                    password: null,
                    password_again: null,

                },
                states: {
                    hasEdited: false,
                    is_form_valid: false,
                },
                uri: null, //uri for api call
            }
        },
        props: {},
        computed: {
            user(){
                return this.$store.getters['auth/session'].user;
            }
        },
        methods: {
            save(){
                if(!this.states.is_form_valid && !this.states.hasEdited)
                    return;
                swalConfirm("", () => {
                    swalLoader();
                    return axios.patch(this.uri, this.inputData)
                        .then((response) => {
                            swalTimer('success', 500)
                                .then( () => {
                                    this.$router.push({
                                        name: 'user-profile'
                                    })
                                });
                        })
                        .catch(axiosErrorCallback)
                    }
                );
            },
            edit(){
                this.states.hasEdited = true
            }
        },
        mounted() {
            this.uri = `/api/v1/users/${this.user.id}/profile/password`
        },
    }
</script>

<style scoped>

</style>
