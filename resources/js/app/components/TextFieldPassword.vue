<template>
    <v-text-field
        type="password"
        class="mx-12"
        :rules="rules"
        :label="label"
        :value="value"
        @input="($event) => $emit('input', $event)"
    ></v-text-field>
</template>

<script>
export default {
name: 'TextFieldPassword',
data(){
    return {}
},
props: {
    label: {
        type: String,
        default: ""
    },
    value: "",
    rules: {
        type: Array,
        default: [],
    }
},
computed: {},
methods:{},
mounted(){

},
}
</script>

<style scoped lang="scss">

</style>
