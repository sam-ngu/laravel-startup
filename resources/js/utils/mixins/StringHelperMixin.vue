
<script>
    export default {
        name: "StringHelperMixin",
        methods: {
            titleCase(value){
                return _.upperFirst(value)
            },
            snakeCase(string){
                return _.snakeCase(string)
            }
        },
    }
</script>

<style scoped>

</style>
