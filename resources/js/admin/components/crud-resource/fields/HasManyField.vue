<template>

    <article>

<!--        if not searchable use dropdown-->

<!--        if searchable use autocomplete-->
        <v-autocomplete
            v-if="searchable"
            :value="value"
            :items="foreignResources"
            :loading="states.isLoading"
            :search-input.sync="search"
            multiple
            outlined
            chips
            deletable-chips
            clearable
            hide-no-data
            hide-selected
            :item-text="itemText"
            :item-value="itemValue"
            placeholder="Start typing to Search"
            prepend-icon="mdi-account_circle"
            @input="($event) => $emit('input', $event)"
            :rules="rules"
            return-object
        />

        <v-select v-else/>


    </article>


</template>

<script>
export default {
    name: "HasManyField",
    data() {
        return {
            states:{
                isLoading: false,
            },
            search: '',
            foreignResources: [],
            searchTimeoutId: null,
        }
    },
    watch: {
        search(name){
            clearTimeout(this.searchTimeoutId);
            this.states.isLoading = true;
            this.searchTimeoutId = setTimeout(function(){
                this.searchResources().finally(function () {
                    this.states.isLoading = false;
                }.bind(this));
            }.bind(this), 1500);
        },
    },
    props: {
        resourceUrl: { // assume resource is searchable is 'searchable' prop is passed in
            type: String,
            required: true,
        },
        value: '',
        searchable: {
            type: Boolean,
            default: true
        },
        itemText: {  // the foreign resource property to show in dropdown
            type: String,
            default: 'id',
        },
        itemValue: {
            type: String,
            default: 'id',
        },
        rules: {
            type: Array,
            default: () => [],
        }
    },
    computed: {},
    methods: {
        searchResources(){
            let uri = this.resourceUrl;
            if(this.searchable) {
                uri += `?search=${this.search}`;
            }

            return axios.get(uri)
                .then((response) => {

                })

        },
    },
    mounted() {

    },
}
</script>

<style scoped>

</style>
