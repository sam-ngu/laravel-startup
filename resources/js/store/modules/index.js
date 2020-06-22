import camelCase from 'lodash/camelCase'
const requireModule = require.context('.', false, '/\.js$/');
const modules = {}

requireModule.keys().forEach((fileName) => {
    // dont register this as Vuex Module

    if(fileName === './index.js'){
        return;
    }
    const moduleName = camelCase(
        fileName.replace(/(\.\/|\.js)/g, '')
    )
    modules[moduleName] = {
        namespaced: true,
        ...requireModule(fileName),
    }
})

export default modules
