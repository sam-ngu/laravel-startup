<template>
    <profile-update-layout title="2 Factor Authentication">

        <template v-slot:body>
            <div>
                <v-form v-model="states.is_form_valid" @submit.prevent="save">

                    <v-btn @click="showQrCode" color="primary" >
                        {{ enabled ? 'Disable' : 'Enable' }}
                    </v-btn>

                    <img  :src="qrCode" alt="qrcode">

                </v-form>

            </div>
        </template>

        <template v-slot:actions>
            <div class="ml-auto">
                <v-btn color="primary" :disabled="!states.hasEdited || !states.is_form_valid" text @click="save">
                    Save
                </v-btn>
            </div>
        </template>
    </profile-update-layout>
</template>

<script>
import ProfileUpdateLayout from "../ProfileUpdateLayout";
import {useAuthStore} from "../../../store/auth-store";
import {useConfirmPassword} from "../../../../utils/auth/confirm-password";

const {getUser} = useAuthStore();
const {openConfirmPasswordDialog, closeConfirmPasswordDialog} = useConfirmPassword();

export default {
    name: 'ProfileUpdate2FA',
    components: {ProfileUpdateLayout},
    data() {
        return {
            states: {
                is_form_valid: true,
            },
            enabled: this.user?.two_factor_enabled,
            qrCode: "",
        }
    },
    props: {},
    computed: {
        user(){
            return getUser();
        }
    },
    methods: {
        save() {
            openConfirmPasswordDialog()
                .then((response) => {
                    console.log('heyy');
                    console.log({response})
                })
                .catch((error) => {

                });

            // let method;
            //
            // if (this.inputData.enabled) {
            //     method = 'POST';
            // } else {
            //     method = 'DELETE';
            // }
            //
            // axios({
            //     method,
            //     url: '/user/two-factor-authentication'
            // }).then((response) => {
            //
            // })
        },
        confirmPassword(){

        },
        showQrCode(){
            openConfirmPasswordDialog();

            // return axios.get('/user/two-factor-qr-code')
            //     .then((response) => {
            //         this.qrCode = response.data.svg;
            //     })
        }
    },
    mounted() {

    },
}
</script>

<style scoped lang="scss">

</style>
