import store from "../vuex-store/store";


const getSession = function(){
    return store.getters['auth/session']
}

const getUser = function (){
    return getSession().user;
}

const setUserTwoFactorEnabled = (isEnabled) => {
    store.commit('auth/setCurrentUser', {
        ...getUser(),
        two_fa_enabled: isEnabled
    })
}


function useAuthStore(){

    return {
        getUser,
        getSession,
        setUserTwoFactorEnabled,
    }

}

export {
    useAuthStore,
}
