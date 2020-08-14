const state = {
    isSidebarOpened: false,
};

const getters = {
    isSidebarOpened(state){
        return state.isSidebarOpened;
    }
};

const actions = {};

const mutations = {
    toggleSidebar(state){
        state.isSidebarOpened = !state.isSidebarOpened;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
