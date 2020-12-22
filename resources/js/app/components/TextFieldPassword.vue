<template>
    <v-text-field
        :append-icon="states.showPassword ? 'mdi-eye' : 'mdi-eye-off'"
        @click:append="states.showPassword = !states.showPassword"
        :type="states.showPassword ? 'text' : 'password'"
        :rules="rules"
        :label="label"
        :value="value"
        @input="($event) => $emit('input', $event)"
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
