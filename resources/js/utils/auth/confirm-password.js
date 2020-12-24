import '../../install-composition-api';
import {reactive, ref} from '@vue/composition-api';


const isConfirmPasswordDialogOpened = ref(false);

const confirmPasswordPromise = reactive({
    resolve: undefined,
    reject: undefined,
})

const openConfirmPasswordDialog = () => {

    return new Promise((resolve, reject) => {
        setTimeout(() => {
            isConfirmPasswordDialogOpened.value = true
            confirmPasswordPromise.resolve = resolve;
            confirmPasswordPromise.reject = reject;
        })

    })
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

const useConfirmPasswordPromise = () => {
    return {
        confirmPasswordPromise,
    }
}

export {
    useConfirmPassword,
    useConfirmPasswordPromise,
}
