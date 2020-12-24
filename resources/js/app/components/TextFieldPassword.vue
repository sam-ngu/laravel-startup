<template>
    <v-text-field
        v-on="$listeners"
        v-bind="$attrs"
        :append-icon="states.showPassword ? 'mdi-eye' : 'mdi-eye-off'"
        @click:append="states.showPassword = !states.showPassword"
        :type="states.showPassword ? 'text' : 'password'"
        :rules="rules"
        :label="label"
        :value="value"
        @change="input"
        @input="input"
    ></v-text-field>
</template>

<script>
export default {
    name: 'TextFieldPassword',
    data() {
        return {
            states: {
                showPassword: false
            }
        }
    },
    methods: {
        input(payload){
            this.$emit('input', payload);
        }
    },
    props: {
        label: {
            type: String,
            default: ""
        },
        value: "",
        rules: {
            type: Array,
            default: () => [],
        }
    },

}
</script>

<style scoped lang="scss">

</style>
