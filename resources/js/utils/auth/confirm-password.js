import appRoutes from "../../app/routes/routes";
import {ref} from '@vue/composition-api';


const isConfirmPasswordDialogOpened = ref(false);

const openConfirmPasswordDialog = () => {
    isConfirmPasswordDialogOpened.value = true
}

const closeConfirmPasswordDialog = () => {
    isConfirmPasswordDialogOpened.value = false
}

const useConfirmPassword = () => {
    return {
        isConfirmPasswordDialogOpened,
        openConfirmPasswordDialog,
        closeConfirmPasswordDialog,
    }
}


export {
    useConfirmPassword
}
