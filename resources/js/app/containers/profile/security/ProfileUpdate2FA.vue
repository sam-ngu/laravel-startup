<template>
    <profile-update-layout title="2 Factor Authentication">

        <template v-slot:body>
            <v-form v-model="states.is_form_valid" @submit.prevent="() => {}">
                <article>
                    <v-list
                        two-line
                        subheader
                    >
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="display-1" :class="{
                                    'success--text': enabled,
                                    'error--text': !enabled,
                                }">

                                        {{ enabled ? 'Enabled' : 'Disabled' }}


                                </v-list-item-title>
                            </v-list-item-content>

                            <v-list-item-action>

                                <v-row>
                                    <v-btn
                                        :disabled="!!qrCode"
                                        v-if="enabled"
                                        outlined
                                        @click="update2Fa"
                                        color="primary"
                                    >
                                        Update
                                    </v-btn>

                                    <v-btn class="ml-2" outlined @click="toggle2FA" color="primary">
                                        {{ enabled ? 'Disable' : 'Enable' }}
                                    </v-btn>
                                </v-row>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </article>

                <article style="position: relative; height: 300px" v-if="states.isLoading">
                    <base-loader/>
                </article>
                <article class="text-center" v-if="enabled && qrCode">

                    <h1>Scan the following QR Code in your Authenticator App.</h1>
                    <div  class="my-12 text-center" v-html="qrCode"></div>

                    <h5 class="body-1">You'll need these backup codes if you ever lose your device:</h5>

                    <p v-for="code in recoveryCodes" :key="code">{{ code }}</p>

                    <v-btn color="primary" text @click="regenerateCodes">Regenerate codes</v-btn>
                </article>
            </v-form>
        </template>

        <template v-slot:actions>

        </template>


    </profile-update-layout>
</template>

<script>
import ProfileUpdateLayout from "../ProfileUpdateLayout";
import {useAuthStore} from "../../../store/auth-store";
import {useConfirmPassword} from "../../../../utils/auth/confirm-password";
import BaseLoader from "../../../../admin/components/crud-resource/partials/BaseLoader";
import {axiosErrorCallback} from "../../../../utils/swal/AxiosHelper";
const {getUser, setUserTwoFactorEnabled} = useAuthStore();
const {openConfirmPasswordDialog, closeConfirmPasswordDialog} = useConfirmPassword();

export default {
    name: 'ProfileUpdate2FA',
    components: {BaseLoader, ProfileUpdateLayout},
    data() {
        return {
            states: {
                is_form_valid: true,
                isLoading: false,
            },
            qrCode: "",
            recoveryCodes: [],
        }
    },
    props: {},
    computed: {
        user() {
            return getUser();
        },

        enabled() {
            return this.user?.two_fa_enabled;
        }

    },
    methods: {
        getRecoveryCodes() {
            return axios.get('/user/two-factor-recovery-codes');
        },
        update2Fa(){
            openConfirmPasswordDialog()
                .then((response) => {
                    console.log({response})
                    if(response){
                        this.showQrCode();
                    }
                })
        },
        regenerateCodes(){
            this.qrCode = '';
            this.recoveryCodes = [];
            return axios.post('/user/two-factor-recovery-codes')
                .then(this.showQrCode)
                .catch(axiosErrorCallback);

        },
        showQrCode(){
            this.states.isLoading = true;
            return Promise.all([
                axios.get('/user/two-factor-qr-code'),
                this.getRecoveryCodes(),
            ]).then((responses) => {
                this.qrCode = responses[0].data.svg;
                this.recoveryCodes = responses[1].data;
                setUserTwoFactorEnabled(true)
                this.states.isLoading = false;

            }).catch(axiosErrorCallback);
        },
        enable2FA() {
            return axios.post('/user/two-factor-authentication')
                .then((response) => {
                    this.showQrCode();
                })
                .catch(axiosErrorCallback);
        },
        disable2FA(){
            axios.delete('/user/two-factor-authentication')
                .then(()=> {
                    setUserTwoFactorEnabled(false);
                })
                .catch(axiosErrorCallback);
        },
        async toggle2FA() {

            openConfirmPasswordDialog()
                .then((response) => {
                    if (!response) {
                        return;
                    }
                    // enable 2fa
                    if(!this.enabled){
                        this.enable2FA();
                    }else{
                        this.disable2FA();
                    }
                })
                .catch((error) => {
                    console.error(error);
                });

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
