import store from "../vuex-store/store";


const getSession = function(){
    return store.getters['auth/session']
}

const getUser = function (){
    return getSession().user;
}


function useAuthStore(){

    return {
        getUser,
        getSession,
    }

}

export {
    useAuthStore,
}
