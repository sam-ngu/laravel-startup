<template>

    <article>

        <span v-if="mode === 'read'" class="text-capitalize">{{ value.join(', ') }}</span>

        <!--        if searchable use autocomplete-->
        <v-autocomplete
            v-else-if="mode === 'write' && searchable"
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
            @input="($event) => $emit('input', $event)"
            :rules="rules"
            return-object
        />
        <!--        if not searchable use dropdown-->
        <v-select v-else/>


        <error-messages :errors="errors" />

    </article>


</template>

<script>
import ErrorMessages from "../partials/ErrorMessages";
export default {
    name: "HasManyField",
    components: {ErrorMessages},
    data() {
        return {
            states:{
                isLoading: false,
            },
            search: '',
            foreignResources: [],
            searchTimeoutId: null,
            errors: {},
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
        },
        mode: {
            type: String,
            default: 'read',
        }
    },
    computed: {},
    methods: {
        searchResources(){
            this.states.isLoading = true;
            let uri = this.resourceUrl;
            if(this.searchable && this.search ) {
                uri += `?search=${this.search}`;
            }

            return axios.get(uri)
                .then((response) => {
                    this.foreignResources = response.data.data;
                    this.states.isLoading = false;

                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                    this.states.isLoading = false;
                })

        },
    },
    mounted() {

    },
}
</script>

<style scoped>

</style>
