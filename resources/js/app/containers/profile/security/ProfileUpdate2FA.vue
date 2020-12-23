<template>
    <profile-update-layout  title="2 Factor Authentication">

        <template v-slot:body>
            <div>
                <v-form v-model="states.is_form_valid" @submit.prevent="save">

                    <article>
                        <v-list
                            two-line
                            subheader
                        >
                            <v-list-item>
                                <v-list-item-content>
                                    <v-list-item-title>
                                        <li :class="{
                                            'success--text': enabled,
                                            'error--text': !enabled,
                                        }">
                                            {{ enabled ? 'Enabled' : 'Disabled' }}
                                        </li>

                                    </v-list-item-title>
                                </v-list-item-content>

                                <v-list-item-action>
                                    <v-btn outlined @click="toggle2FA" color="primary">
                                        {{ enabled ? 'Disable' : 'Enable' }}
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                    </article>

                    <article v-if="enabled">
                        <h1>Open a Two Factor Authenticator app and scan the following QR Code</h1>
                        <div class="text-center" v-html="qrCode"></div>

                        <h5>You'll need these backup codes if you ever lose your device.</h5>

                        <p v-for="code in recoveryCodes" :key="code">{{code}}</p>
                    </article>
                </v-form>
            </div>
        </template>

        <template v-slot:actions>
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
            enabled: undefined,
            qrCode: "",
            recoveryCodes: [],
        }
    },
    props: {},
    computed: {
        user() {
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
        confirmPassword() {

        },
        getRecoveryCodes(){
            return axios.get('/user/two-factor-recovery-codes');
        },
        async toggle2FA() {
            // const response = await axios.get('/user/confirmed-password-status')
            //
            // if (!response.confirmed){
            //
            // }

            openConfirmPasswordDialog()
                .then((response) => {
                    console.log('heyy');
                    console.log({response})
                    if(response){
                        // enable 2fa
                        return axios.post('/user/two-factor-authentication')
                    }
                    throw new Error('Failed to retrieve QR code..');
                })
                .then((response) => {
                    return Promise.all([
                        axios.get('/user/two-factor-qr-code'),
                        this.getRecoveryCodes(),
                    ]);
                })
                .then((responses) => {
                    this.qrCode = responses[0].data.svg;
                    console.log(responses[1]);
                    this.recoveryCodes = responses[1].data;
                })
                .catch((error) => {

                });

            // return axios.get('/user/two-factor-qr-code')
            //     .then((response) => {
            //         this.qrCode = response.data.svg;
            //     })
        }
    },
    mounted() {
        this.enabled = this.user.two_factor_enabled;

    },
}
</script>

<style scoped lang="scss">

</style>
