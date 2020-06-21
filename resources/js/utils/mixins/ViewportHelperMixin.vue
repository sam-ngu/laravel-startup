
<script>
    export default {
        name: "ViewportHelperMixin",
        data() {
            return {}
        },
        computed: {
            viewport(){
                return this.$vuetify.breakpoint.name
            },
            viewport_sm(){
                return this.viewport === 'sm';
            },
            viewport_xs(){
                return this.viewport === 'xs';
            },
            viewport_md(){
                return this.viewport === 'md';
            },
            lg_or_xl(){
                return this.viewport === 'lg' || this.viewport === 'xl';
            },
            sm_or_xs(){
                return this.viewport === 'xs' || this.viewport === 'sm';
            },
        },
        methods: {},
    }
</script>

<style scoped>

</style>
