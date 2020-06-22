import camelCase from 'lodash/camelCase'
const requireModule = require.context('.', true, /\.js$/);
const modules = {}

requireModule.keys().forEach((fileName) => {
    // dont register this as Vuex Module

    if(fileName === './index.js'){
        return;
    }
    const moduleName = camelCase(
        fileName.replace(/(\.\/|\.js)/g, '')
    )
    // console.log({
    //     ...requireModule(fileName)
    // })
    const moduleConfig = requireModule(fileName).default || requireModule(fileName)

    modules[moduleName] = Object.assign({namespaced: true}, {...moduleConfig})
    // console.log({module})

})

export default modules
