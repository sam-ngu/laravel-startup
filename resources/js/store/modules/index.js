import camelCase from 'lodash/camelCase'
const requireModule = require.context('.', false, /\.js$/);
const modules = {}

requireModule.keys().forEach((fileName) => {
    // dont register this as Vuex Module

    if(fileName === './index.js'){
        return;
    }
    const moduleName = camelCase(
        fileName.replace(/(\.\/|\.js)/g, '')
    )
    console.log({
        ...requireModule(fileName)
    })
    const moduleConfig = requireModule(fileName).default || requireModule(fileName)

    const module = Object.assign({namespaced: true}, {...moduleConfig})
    console.log({module})
    modules[moduleName] = module
})

export default modules
