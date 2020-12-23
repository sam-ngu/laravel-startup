<template>
    <v-dialog
        v-model="isConfirmPasswordDialogOpened"
        persistent
        max-width="400"
    >
        <v-card>
            <v-card-title class="title">
                Please confirm your password.
            </v-card-title>
            <v-card-text>
                <text-field-password
                    label="Password"
                    v-model="inputData.password"
                />
                <ul class="error--text">
                    <li v-for="(messages, field) in errors" :key="field">
                        <p class="subtitle-2 text-capitalize">{{field}}</p>
                        <p v-for="message in messages" :key="message">{{message}}</p>
                    </li>
                </ul>

            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn
                    color="grey darken-1"
                    text
                    @click="closeDialog"
                >
                    Cancel
                </v-btn>

                <v-btn
                    color="primary"
                    text
                    @click="confirmPassword"
                >
                    Submit
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import TextFieldPassword from "../../app/components/TextFieldPassword";

import {reactive, ref} from '@vue/composition-api';
import {useConfirmPassword, useConfirmPasswordPromise} from "../../utils/auth/confirm-password";
import ButtonTooltip from "../ButtonTooltip";

export default {
    name: 'ConfirmPasswordDialog',
    components: {ButtonTooltip, TextFieldPassword},
    setup(){

        const {isConfirmPasswordDialogOpened, closeConfirmPasswordDialog} = useConfirmPassword();

        const {confirmPasswordPromise} = useConfirmPasswordPromise();

        const inputData = reactive({
            password: ''
        });

        const errors = ref({});

        const clearInput = () => {
            inputData.password = '';
            errors.value = {};
        }
        const confirmPassword = () => {
            return axios.post('/user/confirm-password', {
                password: inputData.password
            }).then((response) => {
                closeConfirmPasswordDialog();
                clearInput();
                // resolve the dialog promise
                confirmPasswordPromise.resolve(true);
            }).catch((error) => {
                errors.value = error.response.data.errors;

                confirmPasswordPromise.reject(errors.value);
            })
        }

        const closeDialog = () => {
            confirmPasswordPromise.resolve(false);
            closeConfirmPasswordDialog();
            clearInput();
        }

        return {
            errors,
            confirmPassword,
            inputData,
            isConfirmPasswordDialogOpened,
            closeDialog,
        }
    },
    props: {},

}
</script>

<style scoped lang="scss">

</style>
