const state = {
    session: {
        user: {}
    },
    name: 'gege'
};

const getters = {
    session(state){
        return state.session;
    }
};

const actions = {};

const mutations = {
    setCurrentUser(state, user){
        console.log('hey')
        state.session.user = user;
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}