import Vue from 'vue'
import Vuex from 'vuex'

// import modules here
import modules from './modules'
import auth from "./modules/auth";

console.log({modules})

Vue.use(Vuex);

export default new Vuex.Store({
    modules
});
