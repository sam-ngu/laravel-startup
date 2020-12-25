import {ref} from "@vue/composition-api";

const isSidebarOpened = ref(false);

function setSidebarOpened(value){
    isSidebarOpened.value = value;
}

export function useAppStateStore(){

    return {
        setSidebarOpened,
        isSidebarOpened: isSidebarOpened,
    }

}
