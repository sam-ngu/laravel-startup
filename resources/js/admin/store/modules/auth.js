const state = {
    session: {
        user: {}
    },
};

const getters = {
    session(state){
        return state.session;
    }
};

const actions = {};

const mutations = {
    setCurrentUser(state, user){
        state.session.user = user;
    },
    setSession(state, session) {
        state.session = session;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
