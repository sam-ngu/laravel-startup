import store from "../vuex-store/store";


const getSession = function(){
    return store.getters['auth/session']
}

const getUser = function (){
    return getSession().user;
}

const setUser = function (user){
    store.commit('auth/setCurrentUser', {
        ...user
    })
}

const setUserTwoFactorEnabled = (isEnabled) => {
    setUser({
        ...getUser(),
        two_fa_enabled: isEnabled
    })
}


function useAuthStore(){

    return {
        setUser,
        getUser,
        getSession,
        setUserTwoFactorEnabled,
    }

}

export {
    useAuthStore,
}
