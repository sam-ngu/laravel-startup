<template>
    <div>
        <h1>{{ appName }}</h1>
    </div>
</template>

<script>
    export default {
        name: "BaseIndex",
        data() {
            return {

            }
        },
        props: {

        },
        computed: {
          appName(){
            return process.env.MIX_APP_NAME;
          }
        }
    }
</script>

<style scoped>


</style>
