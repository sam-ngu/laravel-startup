const state = {
    fields: [],
    resourceName: '',
    resourceUrl: '',
};

const getters = {
    fields(state){
        return state.fields;
    },
    resourceName(state){
        return state.resourceName
    },
    resourceUrl(state){
        return state.resourceUrl;
    }
};

const actions = {
    fetchResources({state}){
        // FIXME: dont hard code base api url
        return axios.get(state.resourceUrl)
    },
    fetchResource({state}, id){
        return axios.get(state.resourceUrl + `/${id}`)
    },
    patchResource({state}, {id, payload}){
        const uri = state.resourceUrl + `/${id}`
        console.log({uri});
        return axios.patch(uri, payload)
    },
    postResource({state}, payload){
        return axios.post(state.resourceUrl, payload);
    }
};

const mutations = {
    setFields(state, payload){
        state.fields = payload;
    },
    setResourceName(state, payload){
        state.resourceName = payload;
    },
    setResourceUrl(state, payload){
        state.resourceUrl = payload;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
