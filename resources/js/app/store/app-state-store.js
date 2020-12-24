import {ref} from "@vue/composition-api";

const isSidebarOpened = ref(false);



export function useAppStateStore(){

    return {
        isSidebarOpened: isSidebarOpened,
    }

}
