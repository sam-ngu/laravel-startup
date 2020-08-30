<template>
    <layout-master >
        <v-breadcrumbs :items="breadcrumbItems" divider=">"></v-breadcrumbs>
        <router-view></router-view>
    </layout-master>
</template>

<script>
    import LayoutMaster from "./layout/LayoutMaster";

    export default {
        name: 'BaseAdmin',
        components: {
            LayoutMaster,
        },
        data(){
            return{
                breadcrumbItems : this.$route.meta.breadcrumb,
            }
        },
        props: {
            session: { // json string contains the current session info
                type: String,
                required : true,
            }
        },
        computed: {

        },
        watch: {
            '$route'(){ // make sure only the last breadcrumb link is enabled
                _.forEach(this.$route.meta.breadcrumb, function (value, index) {
                    let length = this.$route.meta.breadcrumb.length;
                    // if not the last item
                    this.$route.meta.breadcrumb[index].disabled = length - 1 === index;
                }.bind(this));
                this.$route.meta.breadcrumb[this.$route.meta.breadcrumb.length-1].disabled = true;
                this.breadcrumbItems = this.$route.meta.breadcrumb;
            }
        },
        methods: {


        },
        mounted(){
            // check if session is passed
            const session = JSON.parse(this.session);

            if(this.session && session.user && session.user.roles.find((role) => role.name === 'administrator')) {
                this.$store.commit('auth/setSession', JSON.parse(this.session));
            }else {
                window.location.href = '/login';
            }
            // to route to the correct page if required
            let url = new URL(window.location.href);
            let routeName = url.searchParams.get("to");
            if(routeName){
                this.$router.push({
                    name: routeName
                })
            }
        }
    }
</script>

<style>
    /*#app {*/
        /*font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
        /*-webkit-font-smoothing: antialiased;*/
        /*-moz-osx-font-smoothing: grayscale;*/
        /*text-align: center;*/
        /*color: #2c3e50;*/
        /*margin-top: 60px;*/
    /*}*/
</style>
